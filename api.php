<?php
// PHP 5.6+; lưu tập trung bằng tệp PHP có khóa, không cần cơ sở dữ liệu bên ngoài.
ini_set('display_errors', '0');
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, private');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
if (!is_file(__DIR__ . '/config.php')) { fail('Chưa cấu hình hosting: sao chép config.example.php thành config.php và đặt setup_key riêng ít nhất 24 ký tự.', 503); }
$config = require __DIR__ . '/config.php';
if (!is_array($config) || empty($config['setup_key']) || strlen($config['setup_key']) < 24 || strpos($config['setup_key'], 'THAY_BANG_') === 0) { fail('Đặt setup_key riêng ít nhất 24 ký tự trong config.php trước khi khởi tạo.', 503); }
$course = require __DIR__ . '/course.php';
require_once __DIR__ . '/studio.php';
require_once __DIR__ . '/ai.php';
require_once __DIR__ . '/survey.php';
require_once __DIR__ . '/portal.php';
require_once __DIR__ . '/attendance.php';
require_once __DIR__ . '/roster.php';
$https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
ini_set('session.use_strict_mode', '1');
session_name('AIWORKSHOP');
session_set_cookie_params(0, rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/', '', $https, true);
session_start();
function token() { if(function_exists('random_bytes')) return bin2hex(random_bytes(24)); $strong = false; $bytes = openssl_random_pseudo_bytes(24, $strong); if (!$bytes || !$strong) { throw new Exception('Không tạo được mã phiên an toàn.'); } return bin2hex($bytes); }
function fail($message, $status) { http_response_code($status); echo json_encode(array('error' => $message), JSON_UNESCAPED_UNICODE); exit; }
function cut($value, $max) { if (!is_string($value)) { return ''; } $value = trim($value); if (function_exists('mb_substr')) return mb_substr($value, 0, $max, 'UTF-8'); if (preg_match('/^.{0,' . (int)$max . '}/us', $value, $matches)) return $matches[0]; return ''; }
function admin() { global $config; if (!empty($_SESSION['admin']) && isset($_SESSION['admin_time']) && time() - $_SESSION['admin_time'] <= $config['admin_idle_seconds']) { $_SESSION['admin_time'] = time(); return true; } unset($_SESSION['admin']); return false; }
function need_admin() { if (!admin()) { fail('Vui lòng đăng nhập quản trị.', 401); } }
function initial_state() { return array('version'=>1,'password_hash'=>null,'controls'=>array('open'=>array(),'accept'=>array(),'reveal'=>array(),'featured'=>array(),'focus'=>null,'announcement'=>'Chào mừng thầy/cô. Nội dung sẽ được mở theo nhịp báo cáo viên.','timer'=>0), 'participants'=>array(), 'responses'=>array(), 'attempts'=>array(), 'audit'=>array()); }
function with_state($callback, $write) {
 global $config;
 $dir=$config['data_dir'];
 if (!is_dir($dir) && !@mkdir($dir, 0700, true)) { throw new Exception('Không tạo được thư mục dữ liệu. Kiểm tra quyền ghi của hosting.'); }
 $deny="<IfModule mod_authz_core.c>\nRequire all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\nDeny from all\n</IfModule>\n";
 if (!file_exists($dir.'/.htaccess')) { @file_put_contents($dir.'/.htaccess', $deny); }
 $lock=@fopen($dir.'/access.lock.php','c');
 if (!$lock || !flock($lock, LOCK_EX)) { throw new Exception('Không khóa được dữ liệu.'); }
 try {
  $path=$dir.'/state.php'; $prefix="<?php exit; ?>\n";
  if (file_exists($path)) {
   $raw=file_get_contents($path); if (substr($raw,0,strlen($prefix))!==$prefix) { throw new Exception('Dữ liệu có định dạng không hợp lệ.'); }
   $state=json_decode(substr($raw,strlen($prefix)),true); if (!is_array($state) || !isset($state['controls'])) { throw new Exception('Dữ liệu lỗi; cần kiểm tra bản sao lưu.'); }
  } else { $raw=null; $state=initial_state(); }
  studio_defaults($state);
  survey_defaults($state);
  portal_defaults($state);
  attendance_defaults($state);
  $erased=roster_defaults($state);$write=$write||$erased;
  $result=call_user_func_array($callback,array(&$state));
  if ($write) {
   $erased=$erased||!empty($state['_roster_erased']);unset($state['_roster_erased']);
   $state['version']++;
   $encoded=json_encode($state,JSON_UNESCAPED_UNICODE); if ($encoded===false) { throw new Exception('Không mã hóa được dữ liệu.'); }
   $tmp=$dir.'/write-'.token().'.php';
   if (file_put_contents($tmp,$prefix.$encoded)===false) { throw new Exception('Không ghi được dữ liệu.'); }
   @chmod($tmp,0600);
   if ($raw!==null && file_put_contents($dir.'/previous.php',$erased?$prefix.$encoded:$raw)===false) { @unlink($tmp); throw new Exception('Không lưu được bản dự phòng.'); }
   if (!rename($tmp,$path)) { @unlink($tmp); throw new Exception('Không hoàn tất được ghi dữ liệu.'); }
   @chmod($path,0600); @chmod($dir.'/previous.php',0600);
  }
  flock($lock,LOCK_UN); fclose($lock); return $result;
 } catch (Exception $e) { flock($lock,LOCK_UN); fclose($lock); throw $e; }
}
function section($id) { global $course; foreach($course['sections'] as $s) { if ($s['id']===$id) { return $s; } } fail('Phần học không tồn tại.',400); }
function sanitize_section($s,$reveal,$is_admin) { if (!$is_admin) { unset($s['facilitator']); if (!$reveal) { unset($s['answer'],$s['explanation']); } } return $s; }
function audit(&$state,$message) { $state['audit'][]=array('time'=>gmdate('c'),'message'=>$message); $state['audit']=array_slice($state['audit'],-100); }
try {
 if (empty($_SESSION['csrf'])) { $_SESSION['csrf']=token(); }
 $action=isset($_GET['action'])?$_GET['action']:'state';
 $input=array();
 if ($_SERVER['REQUEST_METHOD']==='POST') {
  if($action==='upload') { $input=$_POST; if(empty($input['csrf'])||!is_string($input['csrf'])||!hash_equals($_SESSION['csrf'],$input['csrf']))fail('Phiên tải tệp không hợp lệ hoặc tệp vượt giới hạn post_max_size của hosting.',403); } else {
  if (stripos(isset($_SERVER['CONTENT_TYPE'])?$_SERVER['CONTENT_TYPE']:'','application/json')!==0) { fail('Yêu cầu phải là JSON.',415); }
  $raw=file_get_contents('php://input', false, null, 0, 524289); if (strlen($raw)>524288) { fail('Dữ liệu quá lớn.',413); }
  $input=json_decode($raw,true); if (!is_array($input)) { fail('Dữ liệu không hợp lệ.',400); }
  if (!isset($input['csrf']) || !is_string($input['csrf']) || !hash_equals($_SESSION['csrf'],$input['csrf'])) { fail('Phiên đã thay đổi. Tải lại trang.',403); }
  }
 } elseif ($action!=='state' && $action!=='portal_state' && $action!=='admin_data') { fail('Thao tác này cần POST.',405); }
 $is_admin=admin();
 if(strpos($action,'portal_')===0){$result=portal_actions($action,$input,$is_admin);
 } elseif(in_array($action,array('survey_submit','survey_control','survey_analyze','survey_reset'),true)){$result=survey_actions($action,$input);
 } elseif(in_array($action,array('ai_settings','ai_save','ai_generate','ai_models'),true)) { $result=ai_actions($action,$input);
 } elseif(in_array($action,array('student_register','student_login','student_logout','studio_save','studio_control','studio_vote','upload'),true)) { $result=studio_actions($action,$input,$is_admin);
 } elseif ($action==='state') {
  $result=with_state(function(&$st) use($course,$is_admin) {
   $outline=array(); $visible=array();
   foreach($course['sections'] as $s) {
    $outline[]=array('id'=>$s['id'],'session'=>$s['session'],'title'=>$s['title'],'minutes'=>$s['minutes'],'level'=>$s['level']);
    if ($is_admin || !empty($st['controls']['open'][$s['id']])) { $visible[]=sanitize_section($s,!empty($st['controls']['reveal'][$s['id']]),$is_admin); }
   }
   $stats=array();
   foreach($st['responses'] as $sid=>$items) { if ($is_admin || !empty($st['controls']['reveal'][$sid])) { $s=section($sid); $counts=array_fill(0,count($s['options']),0); foreach($items as $r) { $counts[$r['choice']]++; } $stats[$sid]=array('total'=>count($items),'counts'=>$counts); } }
   $pid=isset($_SESSION['participant'])?$_SESSION['participant']:null;
   $me=$pid && isset($st['participants'][$pid])?clean_person($st['participants'][$pid]):null;
   $mine=array(); foreach($st['responses'] as $sid=>$items) { if ($pid && isset($items[$pid])) { $mine[$sid]=$items[$pid]; } }
   $gallery=array();
   foreach($st['controls']['featured'] as $key=>$yes) { if ($yes) { $pair=explode('|',$key); if(count($pair)===2 && isset($st['responses'][$pair[0]][$pair[1]])) { $r=$st['responses'][$pair[0]][$pair[1]]; if(!empty($r['share'])) { $p=$st['participants'][$pair[1]]; $gallery[]=array('section'=>$pair[0],'name'=>$p['name'],'school'=>$p['school'],'submission'=>$r['submission'],'link'=>$r['link']); } } } }
   $public_controls=$st['controls']; if(!$is_admin) unset($public_controls['featured']);
   $checked=0;foreach($st['participants'] as $person)if(!empty($person['phone']))$checked++;
   return array('survey'=>survey_summary($st,$is_admin),'checked_in_count'=>$checked,'ai'=>$is_admin?ai_meta():null,'studio'=>studio_summary($st,$is_admin),'server_time'=>time(),'title'=>$course['title'],'presenter'=>$course['presenter'],'sessions'=>$course['sessions'],'tools'=>$course['tools'],'outline'=>$outline,'sections'=>$visible,'controls'=>$public_controls,'stats'=>$stats,'gallery'=>$gallery,'me'=>$me,'mine'=>$mine,'participant_count'=>count($st['participants']),'version'=>$st['version'],'admin'=>$is_admin,'initialized'=>!empty($st['password_hash']),'csrf'=>$_SESSION['csrf']);
  },false);
 } elseif($action==='login' || $action==='setup') {
  $result=with_state(function(&$st) use($action,$input,$config) {
   $ip=hash('sha256',isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'unknown');
   $now=time(); foreach($st['attempts'] as $k=>$v) { if($now-$v['start']>900) unset($st['attempts'][$k]); }
   $a=isset($st['attempts'][$ip])?$st['attempts'][$ip]:array('start'=>$now,'count'=>0);
   if ($a['count']>=8) { return array('error'=>'Thử quá nhiều lần. Vui lòng đợi 15 phút.','status'=>429); }
   $pass=isset($input['password'])?$input['password']:'';
   if (!is_string($pass)||strlen($pass)>200) $pass='';
   $valid=false;
   if ($action==='setup' && empty($st['password_hash'])) {
    $valid=isset($input['setup_key']) && is_string($input['setup_key']) && hash_equals($config['setup_key'],$input['setup_key']) && strlen($pass)>=12;
    if($valid) { $st['password_hash']=password_hash($pass,PASSWORD_DEFAULT); audit($st,'Khởi tạo quản trị.'); }
   } elseif($action==='login' && !empty($st['password_hash'])) { $valid=password_verify($pass,$st['password_hash']); }
   if(!$valid) { $a['count']++; $st['attempts'][$ip]=$a; return array('error'=>'Thông tin không đúng; mật khẩu khởi tạo cần ít nhất 12 ký tự.','status'=>403); }
   unset($st['attempts'][$ip]); session_regenerate_id(true); $_SESSION['admin']=true; $_SESSION['admin_time']=time();
   return array('ok'=>true);
  },true);
  if(isset($result['error'])) { fail($result['error'],$result['status']); }
 } elseif($action==='logout') { unset($_SESSION['admin'],$_SESSION['admin_time']); session_regenerate_id(true); $result=array('ok'=>true);
 } elseif($action==='join') {
  $name=cut(isset($input['name'])?$input['name']:'',80); $school=cut(isset($input['school'])?$input['school']:'',160); $role=cut(isset($input['role'])?$input['role']:'',60);
  if($name===''||$school===''||empty($input['consent'])) { fail('Nhập tên hiển thị, đơn vị và xác nhận lưu thông tin lớp học.',400); }
  $result=with_state(function(&$st) use($name,$school,$role,$config) {
   $pid=isset($_SESSION['participant'])?$_SESSION['participant']:token();
   if(!isset($st['participants'][$pid]) && count($st['participants'])>=$config['max_participants']) { fail('Lớp đã đạt giới hạn đăng ký.',409); }
   $_SESSION['participant']=$pid;
   $st['participants'][$pid]=array('name'=>$name,'school'=>$school,'role'=>$role,'joined'=>isset($st['participants'][$pid])?$st['participants'][$pid]['joined']:gmdate('c'));
   return array('ok'=>true);
  },true);
 } elseif($action==='control') {
  need_admin();
  $result=with_state(function(&$st) use($input,$course) {
   $op=isset($input['op'])?$input['op']:''; $id=isset($input['id'])?$input['id']:'';
   if(in_array($op,array('open','accept','reveal','focus'),true)) {
    section($id);
    if($op==='focus') { if(empty($st['controls']['open'][$id])) { fail('Mở phần học trước khi đưa lên màn hình.',409); } $st['controls']['focus']=$id; }
    else { $value=!empty($input['value']); if($op==='accept' && $value && empty($st['controls']['open'][$id])) fail('Mở phần học trước khi nhận phản hồi.',409); $st['controls'][$op][$id]=$value; if($op==='open' && !$value) { $st['controls']['accept'][$id]=false; $st['controls']['reveal'][$id]=false; if($st['controls']['focus']===$id)$st['controls']['focus']=null; } }
   } elseif($op==='session') {
    $session=(int)$id; if($session<1||$session>3) fail('Buổi không hợp lệ.',400);
    foreach($course['sections'] as $s) { if($s['session']===$session) { $st['controls']['open'][$s['id']]=!empty($input['value']); if(empty($input['value'])) { $st['controls']['accept'][$s['id']]=false; $st['controls']['reveal'][$s['id']]=false; if($st['controls']['focus']===$s['id'])$st['controls']['focus']=null; } } }
   } elseif($op==='announcement') { $st['controls']['announcement']=cut(isset($input['text'])?$input['text']:'',400);
   } elseif($op==='timer') { $seconds=max(0,min(7200,(int)(isset($input['seconds'])?$input['seconds']:0))); $st['controls']['timer']=$seconds?time()+$seconds:0;
   } elseif($op==='feature') {
    $pid=isset($input['participant'])?$input['participant']:''; section($id);
    if(!isset($st['responses'][$id][$pid]) || empty($st['responses'][$id][$pid]['share'])) fail('Bài này chưa được học viên đồng ý chia sẻ.',409);
    $st['controls']['featured'][$id.'|'.$pid]=!empty($input['value']);
   } elseif($op==='password') {
    $current=isset($input['current'])?$input['current']:''; $new=isset($input['password'])?$input['password']:'';
    if(!is_string($current)||!is_string($new)||strlen($new)<12||strlen($new)>200||!password_verify($current,$st['password_hash'])) fail('Mật khẩu hiện tại không đúng hoặc mật khẩu mới chưa đủ 12 ký tự.',403);
    $st['password_hash']=password_hash($new,PASSWORD_DEFAULT);
   } else { fail('Thao tác không hợp lệ.',400); }
   audit($st,'Điều khiển: '.$op.' '.$id); return array('ok'=>true);
  },true);
 } elseif($action==='submit') {
  $id=isset($input['id'])?$input['id']:''; $s=section($id); $choice=isset($input['choice'])?$input['choice']:null;
  if(!is_int($choice)||$choice<0||$choice>=count($s['options'])) fail('Chọn một phương án khảo sát/tình huống.',400);
  $submission=cut(isset($input['submission'])?$input['submission']:'',6000); $link=cut(isset($input['link'])?$input['link']:'',1000);
  if($link!=='' && (!filter_var($link,FILTER_VALIDATE_URL)||!in_array(strtolower(parse_url($link,PHP_URL_SCHEME)),array('http','https'),true))) fail('Liên kết cần bắt đầu bằng http:// hoặc https://.',400);
  $result=with_state(function(&$st) use($id,$choice,$submission,$link,$input) {
   $pid=isset($_SESSION['participant'])?$_SESSION['participant']:'';
   if(!isset($st['participants'][$pid])||empty($st['participants'][$pid]['phone'])) fail('Hoàn thành kiểm diện hoặc đăng nhập bằng số điện thoại trước khi gửi.',401);
   if(empty($st['controls']['open'][$id])||empty($st['controls']['accept'][$id])) fail('Phần này chưa mở nhận phản hồi hoặc đã đóng.',409);
   if(empty($st['responses'][$id]))$st['responses'][$id]=array();
   $st['responses'][$id][$pid]=array('choice'=>$choice,'submission'=>$submission,'link'=>$link,'share'=>!empty($input['share']),'time'=>gmdate('c'));
   $st['controls']['featured'][$id.'|'.$pid]=false;
   return array('ok'=>true);
  },true);
 } elseif($action==='admin_data') {
  need_admin(); $result=with_state(function(&$st){  $people=array();foreach($st['participants'] as $pid=>$p)$people[$pid]=clean_person($p);return array('participants'=>$people,'responses'=>$st['responses'],'studio_votes'=>$st['studio']['votes'],'audit'=>$st['audit']); },false);
 } else { fail('Không có thao tác này.',404); }
 echo json_encode($result,JSON_UNESCAPED_UNICODE);
} catch(Exception $e) { fail($e->getMessage(),500); }


