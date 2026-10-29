<?php
// Danh sách chính và hồ sơ nhập chưa đủ thông tin. Xoá là xoá vĩnh viễn dữ liệu liên quan.
function roster_rows($st){
 $rows=array();$drafts=isset($st['portal']['roster_drafts'])?$st['portal']['roster_drafts']:array();$used=array();
 foreach(portal_directory($st) as $u)foreach($u['people'] as $person){$linked=array();foreach($st['participants'] as $id=>$p)if($p['school']===$u['school']&&$p['name']===$person['name']&&!empty($p['phone']))$linked[$id]=$p;$first=count($linked)?reset($linked):null;$key=attendance_identity($u['school'],$person['name']);$matches=array();foreach($drafts as $id=>$p)if($p['school']===$u['school']&&$p['name']===$person['name']){$matches[$id]=$p;$used[$id]=true;}$draft=count($matches)?reset($matches):null;
  $rows[]=array('key'=>$key,'school'=>$u['school'],'name'=>$person['name'],'role'=>$first?$first['role']:($draft?$draft['role']:$person['role']),'phone'=>$first?$first['phone']:($draft?$draft['phone']:''),'account_count'=>count($linked),'token'=>hash('sha256',json_encode(array($u['school'],$person,$linked,$matches))));
 }
 foreach($drafts as $id=>$p)if(!isset($used[$id]))$rows[]=array_merge($p,array('key'=>$id,'account_count'=>0,'token'=>hash('sha256',json_encode(array($id,$p)))));
 return $rows;
}
function roster_school_token($st,$school,$unit=null){if($unit===null)foreach(portal_directory($st) as $u)if($u['school']===$school)$unit=$u;$people=array();foreach($st['participants'] as $id=>$p)if($p['school']===$school)$people[$id]=$p;$drafts=array();foreach($st['portal']['roster_drafts'] as $id=>$p)if($p['school']===$school)$drafts[$id]=$p;return hash('sha256',json_encode(array($unit,$people,$drafts)));}
function roster_summary($st){$schools=array();$rows=roster_rows($st);$counts=array();foreach($rows as $r)$counts[$r['school']]=isset($counts[$r['school']])?$counts[$r['school']]+1:1;foreach(portal_directory($st) as $u)$schools[]=array('name'=>$u['school'],'count'=>isset($counts[$u['school']])?$counts[$u['school']]:0,'token'=>roster_school_token($st,$u['school'],$u));return array('rows'=>$rows,'schools'=>$schools);}
function roster_import_token($st){return hash('sha256',json_encode(array($st['portal']['directory'],$st['participants'],$st['portal']['roster_drafts'])));}
function roster_forget(&$st,$keys,$schools=array()){
 $ids=array();foreach($st['participants'] as $id=>$p)if(isset($schools[$p['school']])||isset($keys[attendance_identity($p['school'],$p['name'])])){$ids[$id]=true;unset($st['participants'][$id]);}
 foreach($st['portal']['roster_drafts'] as $id=>$p)if(isset($schools[$p['school']])||isset($keys[$id])||($p['school']!==''&&$p['name']!==''&&isset($keys[attendance_identity($p['school'],$p['name'])])))unset($st['portal']['roster_drafts'][$id]);
 $units=array();foreach($st['portal']['directory'] as $u){if(isset($schools[$u['school']]))continue;$u['people']=array_values(array_filter($u['people'],function($p)use($u,$keys){return !isset($keys[attendance_identity($u['school'],$p['name'])]);}));$units[]=$u;}$st['portal']['directory']=$units;
 foreach($st['attendance']['sessions'] as &$session){$changed=false;foreach($session['records'] as $id=>$r)if(isset($ids[$id])||isset($schools[$r['school']])||isset($keys[attendance_identity($r['school'],$r['name'])])){$keys[attendance_identity($r['school'],$r['name'])]=true;unset($session['records'][$id]);$changed=true;}foreach($session['expected'] as $key=>$r)if(isset($keys[$key])||isset($schools[$r['school']])){unset($session['expected'][$key]);$changed=true;}if($changed)$session['revision']++;}unset($session);
 foreach($ids as $id=>$yes){unset($st['survey']['responses'][$id]);foreach($st['responses'] as &$responses)unset($responses[$id]);unset($responses);foreach($st['studio']['votes'] as &$votes)unset($votes[$id]);unset($votes);foreach($st['controls']['featured'] as $key=>$v)if(substr($key,-strlen('|'.$id))==='|'.$id)unset($st['controls']['featured'][$key]);}
 // Báo cáo tổng hợp có thể chứa thông tin đã xoá, huỷ cả tác vụ AI đang chạy.
 $st['survey']['analysis']=array('status'=>'idle');$st['survey']['report_published']=false;$st['survey']['revision']++;$st['attempts']=array();$st['audit']=array();$st['_roster_erased']=true;
}
function roster_defaults(&$st){
 if(!isset($st['portal']['roster_drafts']))$st['portal']['roster_drafts']=array();
 $keys=isset($st['portal']['roster_removed'])?$st['portal']['roster_removed']:array();$schools=isset($st['portal']['schools_removed'])?$st['portal']['schools_removed']:array();
 if(count($keys)||count($schools)){roster_forget($st,$keys,$schools);unset($st['portal']['roster_removed'],$st['portal']['schools_removed']);return true;}unset($st['portal']['roster_removed'],$st['portal']['schools_removed']);return false;
}
function roster_add_school(&$st,$school){if($school==='')return;foreach($st['portal']['directory'] as $u)if($u['school']===$school)return;$st['portal']['directory'][]=array('school'=>$school,'people'=>array());}
function roster_put(&$st,$p,$hashPassword=true){
 roster_add_school($st,$p['school']);
 if($p['school']!==''&&$p['name']!=='')portal_remember($st,$p['school'],$p['name'],$p['role']);
 if($p['school']!==''&&$p['name']!==''&&$p['role']!==''&&$p['phone']!==''){$id=token();$st['participants'][$id]=array_merge($p,array('joined'=>gmdate('c'),'password_hash'=>$hashPassword?password_hash(initial_student_password($p['name'],$p['phone']),PASSWORD_DEFAULT):''));return true;}
 if($p['name']!==''||$p['phone']!==''||$p['role']!==''){$st['portal']['roster_drafts'][token()]=$p;}return false;
}
function roster_actions($action,$input){need_admin();global $config;return with_state(function(&$st)use($action,$input,$config){
 if($action==='portal_roster_school_delete_many'||$action==='portal_roster_delete_many'){
  $schoolAction=$action==='portal_roster_school_delete_many';$items=isset($input['items'])?$input['items']:null;$limit=$schoolAction?500:1000;if(!is_array($items)||!count($items)||count($items)>$limit)fail('Chọn ít nhất một mục, tối đa '.$limit.' mục.',400);
  if(!isset($input['confirm'])||$input['confirm']!=='XOA '.count($items).($schoolAction?' TRUONG':''))fail('Nhập đúng nội dung xác nhận xoá vĩnh viễn.',400);
  $field=$schoolAction?'name':'key';$known=array_column($schoolAction?roster_summary($st)['schools']:roster_rows($st),null,$field);$selected=array();foreach($items as $item){if(!is_array($item)||!isset($item[$field],$item['token'])||!is_string($item[$field])||!is_string($item['token'])||!isset($known[$item[$field]])||!hash_equals($known[$item[$field]]['token'],$item['token']))fail('Danh sách vừa thay đổi. Tải lại rồi chọn lại.',409);if(isset($selected[$item[$field]]))fail('Trùng mục trong yêu cầu xoá.',400);$selected[$item[$field]]=true;}
  roster_forget($st,$schoolAction?array():$selected,$schoolAction?$selected:array());audit($st,'Xoá vĩnh viễn '.count($selected).($schoolAction?' trường cùng dữ liệu liên quan.':' người cùng dữ liệu liên quan.'));return array('ok'=>true,'deleted'=>count($selected));
 }
 if($action==='portal_roster_school_import'||$action==='portal_roster_import'){
  $schoolAction=$action==='portal_roster_school_import';$items=isset($input['rows'])?$input['rows']:null;if(!is_array($items)||!count($items)||count($items)>200)fail('Mỗi lần nhập từ 1 đến 200 dòng.',400);
  $snapshot=roster_import_token($st);$check=$st;$known=roster_rows($st);$seen=array();$skipped=0;$added=0;$accounts=0;$incomplete=0;$empty=0;$schoolsAdded=0;
  foreach($items as $i=>$item){if(!is_array($item))fail('Dòng nhập không hợp lệ.',400);$p=array('school'=>portal_field($item,'school',180),'name'=>$schoolAction?'':portal_field($item,'name',100),'role'=>$schoolAction?'':portal_field($item,'role',100),'phone'=>'');$raw=$schoolAction?'':portal_field($item,'phone',30);$p['phone']=$raw!==''?phone_number($raw):'';
   if(!count(array_filter($p,function($v){return $v!=='';}))){$empty++;continue;}
   $schoolOnly=$p['school']!==''&&$p['name']===''&&$p['role']===''&&$p['phone']==='';$identity=$schoolOnly?'school:'.$p['school']:($p['school']!==''&&$p['name']!==''?'person:'.attendance_identity($p['school'],$p['name']):'draft:'.hash('sha256',json_encode($p)));if(isset($seen[$identity]))fail('Dòng '.($i+2).': trùng dữ liệu trong file.',409);$seen[$identity]=true;
   if($schoolOnly){$exists=false;foreach(portal_directory($check) as $u)if($u['school']===$p['school'])$exists=true;if($exists){$skipped++;continue;}roster_add_school($check,$p['school']);$schoolsAdded++;$added++;continue;}
   $same=null;foreach($known as $r)if(($p['school']!==''&&$p['name']!==''&&$r['school']===$p['school']&&$r['name']===$p['name'])||($r['school']===$p['school']&&$r['name']===$p['name']&&$r['role']===$p['role']&&$r['phone']===$p['phone']))$same=$r;
   if($same){if(($p['role']!==''&&$same['role']!==$p['role'])||($p['phone']!==''&&$same['phone']!==$p['phone']))fail('Dòng '.($i+2).': người đã có thông tin khác. Sửa trực tiếp trong danh sách.',409);$skipped++;continue;}
   if($p['phone']!==''){foreach(roster_rows($check) as $r)if($r['phone']===$p['phone'])fail('Dòng '.($i+2).': số điện thoại đã được sử dụng.',409);}
   if(roster_put($check,$p,false))$accounts++;else $incomplete++;$added++;
  }
  if(count(roster_rows($check))>1000||count(portal_directory($check))>500)fail('Vượt giới hạn 1000 người / 500 trường.',409);if(count(array_filter($check['participants'],function($p){return !empty($p['phone']);}))>$config['max_participants'])fail('Vượt giới hạn tài khoản cấu hình.',409);
  $result=array('ok'=>true,'added'=>$added,'skipped'=>$skipped,'accounts'=>$accounts,'incomplete'=>$incomplete,'schools'=>$schoolsAdded,'empty'=>$empty,'restored'=>0);
  if(empty($input['commit'])){$result['token']=$snapshot;return $result;}
  if(!isset($input['token'])||!is_string($input['token'])||!hash_equals($snapshot,$input['token']))fail('Danh sách vừa thay đổi. Xem trước lại file.',409);
  foreach($check['participants'] as $id=>&$person)if(!isset($st['participants'][$id]))$person['password_hash']=password_hash(initial_student_password($person['name'],$person['phone']),PASSWORD_DEFAULT);unset($person);
  $st['portal']=$check['portal'];$st['participants']=$check['participants'];audit($st,'Nhập Excel: '.$added.' mục, '.$incomplete.' hồ sơ cần bổ sung.');return $result;
 }
 if($action==='portal_roster_save'){
  $key=portal_field($input,'key',64);$old=null;foreach(roster_rows($st) as $r)if($r['key']===$key)$old=$r;
  if($key!==''&&(!$old||!isset($input['token'])||!is_string($input['token'])||!hash_equals($old['token'],$input['token'])))fail('Danh sách vừa thay đổi. Tải lại rồi sửa.',409);if($old&&$old['account_count']>1)fail('Có nhiều tài khoản trùng tên; cần xử lý trùng trước.',409);
  $p=array('school'=>portal_field($input,'school',180),'name'=>portal_field($input,'name',100),'role'=>portal_field($input,'role',100),'phone'=>'');$raw=portal_field($input,'phone',30);$p['phone']=$raw!==''?phone_number($raw):'';if(!count(array_filter($p,function($v){return $v!=='';})))fail('Nhập ít nhất một thông tin.',400);
  foreach(roster_rows($st) as $r)if($r['key']!==$key&&(($p['school']!==''&&$p['name']!==''&&$r['school']===$p['school']&&$r['name']===$p['name'])||($p['phone']!==''&&$r['phone']===$p['phone'])))fail('Trùng người hoặc số điện thoại đã có.',409);
  $pid=null;if($old)foreach($st['participants'] as $id=>$person)if($person['school']===$old['school']&&$person['name']===$old['name']&&!empty($person['phone']))$pid=$id;
  if($pid!==null&&in_array('',$p,true))fail('Tài khoản đã hoạt động cần giữ đầy đủ trường, họ tên, chức vụ và số điện thoại.',400);
  if($old){foreach($st['portal']['directory'] as &$u)if($u['school']===$old['school'])$u['people']=array_values(array_filter($u['people'],function($r)use($old){return $r['name']!==$old['name'];}));unset($u);foreach($st['portal']['roster_drafts'] as $id=>$r)if($id===$key||($old['school']!==''&&$old['name']!==''&&$r['school']===$old['school']&&$r['name']===$old['name']))unset($st['portal']['roster_drafts'][$id]);foreach($st['participants'] as &$r)if(empty($r['phone'])&&$r['school']===$old['school']&&$r['name']===$old['name'])$r=array_merge($r,$p);unset($r);}
  $password=null;if($pid!==null){$st['participants'][$pid]=array_merge($st['participants'][$pid],$p);portal_remember($st,$p['school'],$p['name'],$p['role']);}else{if(roster_put($st,$p))$password=initial_student_password($p['name'],$p['phone']);}
  if(count(roster_rows($st))>1000||count(portal_directory($st))>500)fail('Vượt giới hạn danh sách.',409);if(count(array_filter($st['participants'],function($r){return !empty($r['phone']);}))>$config['max_participants'])fail('Vượt giới hạn tài khoản.',409);audit($st,'Cập nhật hồ sơ tập huấn.');return array('ok'=>true,'initial_password'=>$password,'account'=>$p['phone']);
 }
 if($action==='portal_roster_school_save'){
  $old=portal_field($input,'old_school',180);$name=portal_field($input,'school',180);if($name==='')fail('Nhập tên trường.',400);$exists=false;foreach(portal_directory($st) as $u){if($u['school']===$old)$exists=true;if($u['school']===$name&&$name!==$old)fail('Tên trường đã có. Sửa từng người nếu cần chuyển trường; không gộp tự động.',409);}
  if($old!==''){if(!$exists||!isset($input['token'])||!is_string($input['token'])||!hash_equals(roster_school_token($st,$old),$input['token']))fail('Danh sách trường vừa thay đổi. Tải lại trước khi đổi tên.',409);foreach($st['portal']['directory'] as &$u)if($u['school']===$old)$u['school']=$name;unset($u);foreach($st['participants'] as &$p)if($p['school']===$old)$p['school']=$name;unset($p);foreach($st['portal']['roster_drafts'] as &$p)if($p['school']===$old)$p['school']=$name;unset($p);
   // Trường chỉ được suy ra từ tài khoản vẫn cần có đơn vị trong danh sách lưu.
   $found=false;foreach($st['portal']['directory'] as $u)if($u['school']===$name)$found=true;if(!$found)$st['portal']['directory'][]=array('school'=>$name,'people'=>array());
  }else{if(count(portal_directory($st))>=500)fail('Đã đạt giới hạn 500 trường.',409);$found=false;foreach($st['portal']['directory'] as $u)if($u['school']===$name)$found=true;if(!$found)$st['portal']['directory'][]=array('school'=>$name,'people'=>array());}
  if(count(roster_rows($st))>1000)fail('Danh sách vượt giới hạn 1000 người.',409);
  audit($st,'Cập nhật trường tập huấn: '.$name);return array('ok'=>true);
 }
 fail('Thao tác danh sách không hợp lệ.',404);
 },true);}
