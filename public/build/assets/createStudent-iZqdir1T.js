import{T as v,o as l,f as d,a as r,w as i,u as t,F as x,d as c,Z as y,b as e,j as b,e as w,i as m,k as _,t as p,g as h}from"./app-Dk-Q8yL7.js";import{_ as g}from"./FrontendLayout-DrHqIwa6.js";const k={class:"mt-4 mx-4"},S={class:"flex justify-between"},N=e("h3",null,"Create Student",-1),B={class:"grid grid-cols-12 gap-4"},V={class:"col-span-6"},C={class:"mb-3"},T=e("label",null,"Student Name",-1),D={key:0,class:"text-red-500"},E={class:"mb-3"},j=e("label",null,"Batch",-1),F={key:0,class:"text-red-500"},O={class:"mb-3"},U=e("label",null,"Test Number",-1),M={key:0,class:"text-red-500"},$={class:"mb-3"},q=["disabled"],R={key:0},Z={key:1},G={__name:"createStudent",props:{errors:Object},setup(n){const s=v({name:"",wave:"",no_test:""}),f=()=>{s.post(route("students.store"))&&s.reset()};return(u,o)=>(l(),d(x,null,[r(t(y),{title:"Create Student Data"},{default:i(()=>[c(" Create Student Data ")]),_:1}),r(g,null,{default:i(()=>[e("div",k,[e("div",S,[N,r(t(b),{href:u.route("students.index"),class:"bg-red-500 text-white py-2 px-5 rounded mb-4 inline-block"},{default:i(()=>[c("Back")]),_:1},8,["href"])]),e("form",{onSubmit:o[3]||(o[3]=w(a=>f(),["prevent"]))},[e("div",B,[e("div",V,[e("div",C,[T,m(e("input",{type:"text","onUpdate:modelValue":o[0]||(o[0]=a=>t(s).name=a),placeholder:"Enter Full Name (Required)",class:"py-1 w-full"},null,512),[[_,t(s).name]]),n.errors.name?(l(),d("div",D,p(n.errors.name),1)):h("",!0)]),e("div",E,[j,m(e("input",{type:"text","onUpdate:modelValue":o[1]||(o[1]=a=>t(s).wave=a),placeholder:"Enter Batch (Optional)",class:"py-1 w-full"},null,512),[[_,t(s).wave]]),n.errors.wave?(l(),d("div",F,p(n.errors.wave),1)):h("",!0)]),e("div",O,[U,m(e("input",{type:"text","onUpdate:modelValue":o[2]||(o[2]=a=>t(s).no_test=a),placeholder:"Enter No Test (Optional)",class:"py-1 w-full"},null,512),[[_,t(s).no_test]]),n.errors.no_test?(l(),d("div",M,p(n.errors.no_test),1)):h("",!0)]),e("div",$,[r(t(b),{href:u.route("students.index"),class:"bg-red-600 text-white py-2 px-5 rounded mb-4 inline-block"},{default:i(()=>[c(" Back ")]),_:1},8,["href"]),e("button",{type:"submit",disabled:t(s).processing,class:"bg-blue-500 text-white py-2 px-5 rounded mb-4"},[t(s).processing?(l(),d("span",R,"Saving...")):(l(),d("span",Z,"Save"))],8,q)])])])],32)])]),_:1})],64))}};export{G as default};
