// Chạy: PHP_BIN=/path/to/php node tests/integration.cjs
// Toàn bộ dữ liệu được tạo trong thư mục tạm, không dùng config/dữ liệu thật.
const fs=require('node:fs'),path=require('node:path'),os=require('node:os'),assert=require('node:assert/strict'),{spawn}=require('node:child_process'),net=require('node:net');
(async()=>{
 const root=path.resolve(__dirname,'..'),tmp=fs.mkdtempSync(path.join(os.tmpdir(),'taphuan-test-'));
 let server;
 try{
 fs.cpSync(root,tmp,{recursive:true,filter:p=>!['.git','config.php','workshop-data','workshop-media','node_modules'].includes(path.basename(p))});
 fs.writeFileSync(path.join(tmp,'config.php'),"<?php return array('setup_key'=>'TEST_ONLY_portal_setup_2026_abc123','data_dir'=>__DIR__.'/workshop-data','max_participants'=>200,'admin_idle_seconds'=>28800);");
 const source=fs.readFileSync(path.join(root,'survey.php'),'utf8'),qs=JSON.parse(source.split("<<<'SURVEY'\n")[1].split('\nSURVEY')[0]),answers={};
 for(const q of qs)answers[q.id]=q.type==='text'?'Một ví dụ thử nghiệm':q.type==='multi'?[0]:0;
 const legacy={version:7,password_hash:null,controls:{open:{},accept:{},reveal:{},featured:{},focus:null,announcement:'Cũ',timer:0},participants:{legacy:{name:'Người dùng cũ',school:'Trường mẫu cũ',role:'Hiệu trưởng',phone:'0900000001',joined:'2026-10-01T00:00:00Z'}},responses:{'s1-1':{legacy:{choice:0,submission:'Bài làm cũ',link:'',share:false}}},attempts:{},audit:[],survey:{status:'closed',revision:1,responses:{legacy:{answers,updated:'2026-10-01T00:00:00Z'}},published:false,report_published:false,analysis:{status:'idle'}}};
 fs.mkdirSync(path.join(tmp,'workshop-data'));fs.writeFileSync(path.join(tmp,'workshop-data/state.php'),'<?php exit; ?>\n'+JSON.stringify(legacy));
 const port=await new Promise(r=>{const s=net.createServer();s.listen(0,'127.0.0.1',()=>{const port=s.address().port;s.close(()=>r(port));});});
 server=spawn(process.env.PHP_BIN||'php',['-n','-d','session.save_path='+tmp,'-S','127.0.0.1:'+port,'-t',tmp],{stdio:['ignore','ignore','pipe']});let log='';server.stderr.on('data',x=>{log+=x});
 const url='http://127.0.0.1:'+port+'/api.php?action=';
 function client(){let cookie='',csrf='';return async(action,data,expected=200)=>{const res=await fetch(url+action,{headers:{...(cookie?{cookie}:{}),...(data?{'Content-Type':'application/json'}:{})},...(data?{method:'POST',body:JSON.stringify({...data,csrf})}:{})});const set=res.headers.get('set-cookie');if(set)cookie=set.split(';')[0];const v=await res.json();assert.equal(res.status,expected,action+" "+JSON.stringify(v)+" log="+log);if(v.csrf)csrf=v.csrf;return v;};}
 const admin=client(),learner=client(),publicUser=client();let first;
 async function scan(who,id){const proof=await admin('portal_attendance_qr',{session:id});await who('portal_scan',{session:id,slot:proof.slot,signature:proof.signature});return proof;}
 for(let i=0;i<40;i++){try{first=await admin('portal_state');break;}catch(e){if(i===39)throw Error(log+'\n'+e);await new Promise(r=>setTimeout(r,50));}}
 assert.equal(first.topics.length,18);assert.equal(first.checked_in_count,1);assert.equal(first.people.length,0);assert.equal(first.survey.mine,null);
 await admin('setup',{setup_key:'TEST_ONLY_portal_setup_2026_abc123',password:'test-admin-password-2026'});let st=await admin('portal_state');assert.equal(st.admin,true);assert.equal(st.people[0].answered,true);
 await publicUser('portal_state');await publicUser('portal_event_save',{title:'Bị chặn',revision:1},401);await publicUser('portal_topic_save',{title:'Bị chặn'},401);await publicUser('portal_tool_delete',{id:'gemini',revision:1},401);
 await learner('portal_state');await learner('portal_checkin',{school:'Trường mẫu mới',name:'Người mới',role:'',phone:'0900000002'},400);
 const session1=(await admin('portal_attendance_create',{title:'Buổi 1',date:'2026-10-28'})).id;
 await learner('portal_checkin',{session:session1,school:'Trường mẫu mới',name:'Người mới',role:'Phó hiệu trưởng',phone:'0900000002'},409);
 await scan(learner,session1);const registration=await learner('portal_checkin',{session:session1,school:'Trường mẫu mới',name:'Người mới',role:'Phó hiệu trưởng',phone:'0900000002'});assert(registration.initial_password);
 let me=await learner('portal_state');assert.equal(me.me.name,'Người mới');assert.equal(me.checked_in_count,2);assert(me.directory.some(u=>u.school==='Trường mẫu mới'&&u.people[0].role==='Phó hiệu trưởng'));
 await learner('student_logout',{});await scan(learner,session1);await learner('portal_checkin',{session:session1,school:'Trường mẫu mới',name:'Người mới',role:'Phó hiệu trưởng',phone:'0900000002'});assert.equal((await learner('portal_state')).checked_in_count,2);
 await scan(learner,session1);await learner('portal_checkin',{session:session1,school:'Trường mẫu mới',name:'Người mới',role:'Phó hiệu trưởng',phone:'0900000003'},409);
 await learner('portal_checkin',{session:session1,school:'Trường sai',name:'Người khác',role:'Hiệu trưởng',phone:'0900000002'},409);

 // Không phát QR công khai, không cho khách tạo/đóng buổi, không lộ bản ghi người khác.
 await publicUser('portal_attendance_qr',{session:session1},401);await publicUser('portal_attendance_create',{title:'Giả',date:'2026-10-28'},401);
 const publicState=await publicUser('portal_state');assert(!JSON.stringify(publicState.attendance).includes('signature'));assert(!JSON.stringify(publicState.attendance).includes('nonce'));assert(!publicState.attendance.sessions[0].rows);
 let astate=await admin('portal_state');assert.equal(astate.attendance.sessions[0].count,1);assert(astate.attendance.sessions[0].rows.some(p=>p.name==='Người dùng cũ'&&!p.present));
 const checker=client();await checker('portal_state');const proof1=await admin('portal_attendance_qr',{session:session1});
 await checker('portal_scan',{...proof1,signature:'0'.repeat(64)},409);
 await checker('portal_scan',{...proof1,slot:proof1.slot-1},409);
 // Chữ ký hợp lệ của chu kỳ trước cũng bị từ chối; không chỉ kiểm tra chữ ký.
 const crypto=require('node:crypto'),readDisk=()=>JSON.parse(fs.readFileSync(path.join(tmp,'workshop-data/state.php'),'utf8').split('\n').slice(1).join('\n'));
 const nonce=readDisk().attendance.sessions[session1].nonce,oldSlot=proof1.slot-1,oldSignature=crypto.createHmac('sha256','TEST_ONLY_portal_setup_2026_abc123').update(session1+'|'+nonce+'|'+oldSlot).digest('hex');
 await checker('portal_scan',{session:session1,slot:oldSlot,signature:oldSignature},409);
 await scan(checker,session1);await checker('portal_checkin',{session:'sai-buoi',school:'Trường mẫu mới',name:'Người mới',role:'Phó hiệu trưởng',phone:'0900000002'},409);
 // Mở buổi 2 đóng buổi 1 và vô hiệu quyền điền phiếu đang giữ của buổi cũ.
 const session2=(await admin('portal_attendance_create',{title:'Buổi 2',date:'2026-10-29'})).id;
 await checker('portal_checkin',{session:session1,school:'Trường mẫu mới',name:'Người mới',role:'Phó hiệu trưởng',phone:'0900000002'},409);
 await checker('portal_scan',proof1,409);await admin('portal_attendance_qr',{session:session1},409);
 await scan(checker,session2);await checker('portal_checkin',{session:session2,school:'Trường mẫu mới',name:'Người mới',role:'Phó hiệu trưởng',phone:'0900000002'});
 astate=await admin('portal_state');assert.equal(astate.attendance.sessions.find(s=>s.id===session1).count,1);assert.equal(astate.attendance.sessions.find(s=>s.id===session2).count,1);assert.equal(astate.checked_in_count,2);
 // Đăng nhập thông thường không ghi nhận có mặt vào một buổi mới.
 const session3=(await admin('portal_attendance_create',{title:'Buổi 3',date:'2026-10-30'})).id;
 const loginOnly=client();await loginOnly('portal_state');await loginOnly('student_login',{phone:'0900000002',password:registration.initial_password});assert.equal((await admin('portal_state')).attendance.sessions.find(s=>s.id===session3).count,0);
 // Quyền điền phiếu hết hạn sau 10 phút và bị thu hồi khi đóng/mở lại buổi.
 await scan(checker,session3);await admin('portal_attendance_control',{session:session3,op:'close'});await checker('portal_checkin',{session:session3,school:'Trường mẫu mới',name:'Người mới',role:'Phó hiệu trưởng',phone:'0900000002'},409);
 await admin('portal_attendance_control',{session:session1,op:'open'});await checker('portal_scan',proof1,409);await scan(checker,session1);await checker('portal_checkin',{session:session1,school:'Trường mẫu mới',name:'Người mới',role:'Phó hiệu trưởng',phone:'0900000002'});assert.equal((await admin('portal_state')).attendance.sessions.find(s=>s.id===session1).count,1);
 // Phiếu hết hạn dù buổi vẫn đang mở: chỉnh thời gian phiên kiểm thử, không đợi thật.
 await scan(checker,session1);for(const file of fs.readdirSync(tmp).filter(n=>n.startsWith('sess_'))){const p=path.join(tmp,file),data=fs.readFileSync(p,'utf8');if(data.includes('attendance_grant'))fs.writeFileSync(p,data.replace(/("expires";i:)\d+;/g,'$11;'));}
 await checker('portal_checkin',{session:session1,school:'Trường mẫu mới',name:'Người mới',role:'Phó hiệu trưởng',phone:'0900000002'},409);
 await admin('portal_attendance_create',{title:'Sai ngày',date:'2026-02-30'},400);

 await admin('survey_control',{op:'open'});await learner('survey_submit',{answers:{...answers,q1:999}},400);
 const multi=qs.find(q=>q.type==='multi');await learner('survey_submit',{answers:{...answers,[multi.id]:[0,1,2,3]}},400);
 await learner('survey_submit',{answers});await learner('survey_submit',{answers});st=await admin('portal_state');assert.equal(st.survey.stats.respondents,2);assert.equal(st.people.filter(p=>p.answered).length,2);
 me=await learner('portal_state');assert.equal(me.survey.mine.answers.q15,answers.q15);assert.equal(me.survey.stats,null);assert.equal(me.people.length,0);assert.equal(me.ai,null);
 const event={...st.event,title:'Đợt tập huấn thử nghiệm',revision:st.event_revision};await admin('portal_event_save',event);await admin('portal_event_save',event,409);assert.equal((await learner('portal_state')).event.title,event.title);
 await admin('portal_topic_save',{title:'Chuyên đề mới',group:'Buổi 4',body:'ấ'.repeat(30000),prompt:'ấ'.repeat(6000),published:false,order:25});st=await admin('portal_state');let topic=st.topics.find(t=>t.title==='Chuyên đề mới');assert(topic);assert.equal(topic.body.length,30000);assert.equal(topic.prompt.length,6000);assert(!(await learner('portal_state')).topics.some(t=>t.id===topic.id));
 await admin('portal_topic_save',{...topic,published:true,body:'Đã biên tập'});assert((await learner('portal_state')).topics.some(t=>t.id===topic.id&&t.body==='Đã biên tập'));
 await admin('portal_topic_save',{...topic,body:'Ghi đè bản cũ'},409);await admin('portal_topic_delete',{id:topic.id,revision:topic.revision},409);st=await admin('portal_state');topic=st.topics.find(t=>t.id===topic.id);await admin('portal_topic_delete',{id:topic.id,revision:topic.revision});assert(!(await admin('portal_state')).topics.some(t=>t.id===topic.id));
 await admin('portal_tool_save',{name:'Link xấu',url:'javascript:alert(1)'},400);await admin('portal_tool_save',{name:'Câu lệnh thử',url:'https://example.com',prompt:'Hãy lập kế hoạch [nội dung]'});st=await admin('portal_state');const tool=st.tools.find(t=>t.name==='Câu lệnh thử');assert(tool);await admin('portal_tool_save',{...tool,description:'Đã sửa'});await admin('portal_tool_delete',{id:tool.id,revision:tool.revision},409);await admin('portal_tool_delete',{id:tool.id,revision:tool.revision+1});
 await admin('survey_control',{op:'publish',value:true});assert.equal((await learner('portal_state')).survey.stats.respondents,2);await admin('survey_control',{op:'publish',value:false});assert.equal((await learner('portal_state')).survey.stats,null);
 // Không gọi AI thật. Chỉ kiểm tra quyền và thông báo khi chưa cấu hình.
 await learner('ai_generate',{task:'outline',prompt:'test'},401);await admin('ai_generate',{task:'outline',prompt:'test'},409);
 const disk=JSON.parse(fs.readFileSync(path.join(tmp,'workshop-data/state.php'),'utf8').split('\n').slice(1).join('\n'));assert.equal(disk.responses['s1-1'].legacy.submission,'Bài làm cũ');assert.equal(disk.survey.responses.legacy.answers.q15,answers.q15);assert(disk.portal.directory.some(u=>u.school==='Trường mẫu mới'));assert(fs.existsSync(path.join(tmp,'workshop-data/previous.php')));
 const replay=client();const after=await replay('portal_state');assert.equal(after.checked_in_count,2);assert(after.directory.some(u=>u.school==='Trường mẫu mới'));assert(!JSON.stringify(after).includes('password_hash'));assert(!JSON.stringify(after.directory).includes('0900000002'));
 console.log('PASS: rotating signed QR, expired/tampered/revoked codes and grants, per-session attendance without duplicates, login without attendance, legacy migration, check-in/re-entry, directory persistence, account survey counts, validation, access control, event/topic/tool CRUD, revision conflicts and data preservation.');
 }finally{if(server)server.kill();fs.rmSync(tmp,{recursive:true,force:true});}
})().catch(e=>{console.error(e);process.exitCode=1;});
