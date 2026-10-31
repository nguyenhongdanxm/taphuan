<?php
// Tệp đính kèm công cụ: lưu trong thư mục dữ liệu được bảo vệ, chỉ phục vụ qua API.
function tool_file_path($id){global $config;if(!is_string($id)||!preg_match('/^[a-f0-9]{32}$/D',$id))return null;return $config['data_dir'].'/files/'.$id.'.bin';}
function tool_file_meta($f){return array('id'=>$f['id'],'name'=>$f['name'],'ext'=>$f['ext'],'size'=>$f['size'],'mime'=>$f['mime']);}
function tool_file_used($st,$id){foreach($st['portal']['tools'] as $t)if(isset($t['files'])&&in_array($id,$t['files'],true))return true;return false;}
function tool_files_cleanup(&$st,$removed=array()){
 if(!isset($st['portal']['files']))$st['portal']['files']=array();
 foreach($st['portal']['files'] as $id=>$f)if(!tool_file_used($st,$id)&&(in_array($id,$removed,true)||time()-$f['created']>86400)){$st['_tool_file_delete'][]=$id;unset($st['portal']['files'][$id]);}
}
function tool_files_for_tool($st,$tool){$out=array();foreach(isset($tool['files'])?$tool['files']:array() as $id)if(isset($st['portal']['files'][$id]))$out[]=tool_file_meta($st['portal']['files'][$id]);return $out;}
function tool_files_validate($st,$input,$old){$ids=isset($input['files'])?$input['files']:(isset($old['files'])?$old['files']:array());if(!is_array($ids)||count($ids)>10)fail('Mỗi công cụ tối đa 10 tệp.',400);foreach($ids as $id)if(!is_string($id)||!isset($st['portal']['files'][$id]))fail('Tệp đính kèm không còn tồn tại. Tải lại tệp trước khi lưu.',409);if(count(array_unique($ids))!==count($ids))fail('Tệp đính kèm bị trùng.',400);return $ids;}
function tool_office_valid($path,$ext){
 // Đọc central directory để xác nhận đúng họ OOXML, không giải nén nội dung trên hosting.
 $data=file_get_contents($path);$end=strrpos($data,"PK\x05\x06");if($end===false||strlen($data)-$end<22)return false;$tail=unpack('vdisk/vstart/vdiskcount/vcount/Vsize/Voffset/vcomment',substr($data,$end+4,18));if($tail['disk']||$tail['start']||$tail['count']>10000||$tail['offset']+$tail['size']>$end)return false;
 $pos=$tail['offset'];$names=array();for($i=0;$i<$tail['count'];$i++){if(substr($data,$pos,4)!=="PK\x01\x02"||$pos+46>strlen($data))return false;$h=unpack('vflags/vmethod/vtime/vdate/Vcrc/Vcompressed/Vsize/vname/vextra/vcomment/vdisk/vinternal/Vexternal/Vlocal',substr($data,$pos+8,38));if($h['flags']&1)return false;$name=substr($data,$pos+46,$h['name']);if(stripos($name,'vbaProject.bin')!==false)return false;$names[$name]=true;$pos+=46+$h['name']+$h['extra']+$h['comment'];}
 $main=array('docx'=>'word/document.xml','xlsx'=>'xl/workbook.xml','pptx'=>'ppt/presentation.xml');return isset($names['[Content_Types].xml'],$names[$main[$ext]]);
}
function tool_file_upload(){need_admin();
 if(empty($_FILES['file'])||!isset($_FILES['file']['error'])||$_FILES['file']['error']!==UPLOAD_ERR_OK)fail('Tải tệp không thành công. Kiểm tra giới hạn upload_max_filesize / post_max_size của hosting.',400);
 $f=$_FILES['file'];if(!is_string($f['name'])||!is_uploaded_file($f['tmp_name']))fail('Tệp tải lên không hợp lệ.',400);if($f['size']<=0||$f['size']>20*1024*1024)fail('Mỗi tệp tối đa 20 MB và không được rỗng.',413);
 $ext=strtolower(pathinfo($f['name'],PATHINFO_EXTENSION));$allowed=array('pdf'=>'application/pdf','txt'=>'text/plain','csv'=>'text/csv','jpg'=>'image/jpeg','jpeg'=>'image/jpeg','png'=>'image/png','webp'=>'image/webp','gif'=>'image/gif','docx'=>'application/vnd.openxmlformats-officedocument.wordprocessingml.document','xlsx'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','pptx'=>'application/vnd.openxmlformats-officedocument.presentationml.presentation','zip'=>'application/zip');
 if(!isset($allowed[$ext]))fail('Nhận PDF, DOCX, XLSX, PPTX, TXT, CSV, JPG, PNG, WEBP, GIF và ZIP. Tệp Office cũ cần lưu sang định dạng mới.',400);
 if(!function_exists('finfo_open'))fail('Hosting cần bật phần mở rộng PHP fileinfo để tải tệp.',503);$fi=finfo_open(FILEINFO_MIME_TYPE);$mime=finfo_file($fi,$f['tmp_name']);finfo_close($fi);
 if(in_array($ext,array('docx','xlsx','pptx'),true)){if(!in_array($mime,array('application/zip','application/octet-stream',$allowed[$ext]),true)||!tool_office_valid($f['tmp_name'],$ext))fail('Tệp Office không hợp lệ, sai loại hoặc có macro/mật khẩu.',400);}
 elseif($ext==='csv'){if(!in_array($mime,array('text/plain','text/csv','application/csv'),true))fail('CSV phải là tệp văn bản.',400);}
 elseif($ext==='zip'){if(!in_array($mime,array('application/zip','application/x-zip-compressed'),true))fail('Tệp ZIP không hợp lệ.',400);}
 elseif($mime!==$allowed[$ext])fail('Nội dung tệp không khớp phần mở rộng.',400);
 $id=substr(token(),0,32);$name=cut(preg_replace('/[\x00-\x1F\x7F\\\\\/]/','_', $f['name']),180);$asset=array('id'=>$id,'name'=>$name,'ext'=>$ext,'mime'=>$allowed[$ext],'size'=>(int)$f['size'],'created'=>time());$saved=false;
 try{return with_state(function(&$st)use($f,$id,$asset,&$saved){global $config;tool_files_cleanup($st);if(count($st['portal']['files'])>=500)fail('Đã đạt giới hạn 500 tệp. Gỡ các tệp không còn dùng.',409);$total=$asset['size'];foreach($st['portal']['files'] as $a)$total+=$a['size'];if($total>500*1024*1024)fail('Kho tài liệu đã đạt giới hạn 500 MB.',409);
  $dir=$config['data_dir'].'/files';if(!is_dir($dir)&&!mkdir($dir,0700,true))throw new Exception('Không tạo được thư mục tài liệu.');$deny="<IfModule mod_authz_core.c>\nRequire all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\nDeny from all\n</IfModule>\n";if(file_put_contents($dir.'/.htaccess',$deny)===false)throw new Exception('Không bảo vệ được thư mục tài liệu.');$path=tool_file_path($id);if(!move_uploaded_file($f['tmp_name'],$path))throw new Exception('Không lưu được tệp.');$saved=true;chmod($path,0600);$st['portal']['files'][$id]=$asset;audit($st,'Tải tệp đính kèm công cụ.');return array('ok'=>true,'file'=>tool_file_meta($asset));
 },true);}catch(Exception $e){if($saved)@unlink(tool_file_path($id));throw $e;}
}
function tool_file_serve(){
 $id=isset($_GET['id'])?$_GET['id']:'';if(!tool_file_path($id))fail('Không tìm thấy tệp.',404);$is_admin=admin();$f=with_state(function(&$st)use($id,$is_admin){if(!isset($st['portal']['files'][$id])||(!$is_admin&&!tool_file_used($st,$id)))fail('Không tìm thấy tệp.',404);return $st['portal']['files'][$id];},false);$path=tool_file_path($id);if(!is_file($path))fail('Tệp không còn trên hosting.',404);
 $inline=in_array($f['ext'],array('pdf','txt','csv','jpg','jpeg','png','webp','gif','docx','xlsx','pptx'),true)&&empty($_GET['download']);session_write_close();header('Content-Type: '.($f['ext']==='csv'&&$inline?'text/plain':$f['mime']).(in_array($f['ext'],array('txt','csv'),true)?'; charset=utf-8':''));header('Content-Disposition: '.($inline?'inline':'attachment').'; filename="document-'.$id.'.'.$f['ext'].'"; filename*=UTF-8\'\''.rawurlencode($f['name']));header('Content-Length: '.filesize($path));header('X-Content-Type-Options: nosniff');if($_SERVER['REQUEST_METHOD']==='HEAD')exit;$handle=fopen($path,'rb');while(!feof($handle)){echo fread($handle,1024*1024);if(connection_aborted())break;}fclose($handle);exit;
}
