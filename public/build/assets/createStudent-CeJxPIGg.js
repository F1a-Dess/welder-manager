import{T as b,o as l,f as r,a as d,w as i,u as s,F as f,d as h,Z as x,b as e,e as y,i as u,k as c,t as m,g as _,j as w}from"./app-DCe8GlOL.js";import{_ as g}from"./FrontendLayout-DyUpZ1mk.js";const k={class:"mt-4 mx-4"},S=e("div",{class:"flex justify-between"},[e("h3",null,"Create Student")],-1),N={class:"grid grid-cols-12 gap-4"},V={class:"col-span-6"},B={class:"mb-3"},C=e("label",null,"Student Name",-1),T={key:0,class:"text-red-500"},D={class:"mb-3"},E=e("label",null,"Batch",-1),j={key:0,class:"text-red-500"},F={class:"mb-3"},O=e("label",null,"Test Number",-1),U={key:0,class:"text-red-500"},M={class:"mb-3"},$=["disabled"],q={key:0},R={key:1},A={__name:"createStudent",props:{errors:Object},setup(a){const t=b({name:"",wave:"",no_test:""}),v=()=>{t.post(route("students.store"))&&t.reset()};return(p,o)=>(l(),r(f,null,[d(s(x),{title:"Create Student Data"},{default:i(()=>[h(" Create Student Data ")]),_:1}),d(g,null,{default:i(()=>[e("div",k,[S,e("form",{onSubmit:o[3]||(o[3]=y(n=>v(),["prevent"]))},[e("div",N,[e("div",V,[e("div",B,[C,u(e("input",{type:"text","onUpdate:modelValue":o[0]||(o[0]=n=>s(t).name=n),placeholder:"Enter Full Name (Required)",class:"py-1 w-full"},null,512),[[c,s(t).name]]),a.errors.name?(l(),r("div",T,m(a.errors.name),1)):_("",!0)]),e("div",D,[E,u(e("input",{type:"text","onUpdate:modelValue":o[1]||(o[1]=n=>s(t).wave=n),placeholder:"Enter Batch (Optional)",class:"py-1 w-full"},null,512),[[c,s(t).wave]]),a.errors.wave?(l(),r("div",j,m(a.errors.wave),1)):_("",!0)]),e("div",F,[O,u(e("input",{type:"text","onUpdate:modelValue":o[2]||(o[2]=n=>s(t).no_test=n),placeholder:"Enter No Test (Optional)",class:"py-1 w-full"},null,512),[[c,s(t).no_test]]),a.errors.no_test?(l(),r("div",U,m(a.errors.no_test),1)):_("",!0)]),e("div",M,[d(s(w),{href:p.route("students.index"),class:"bg-red-600 text-white py-2 px-5 rounded mb-4 mr-2 ml-2 inline-block"},{default:i(()=>[h(" Back ")]),_:1},8,["href"]),e("button",{type:"submit",disabled:s(t).processing,class:"bg-blue-500 text-white py-2 px-5 rounded mb-4 mr-2 ml-2"},[s(t).processing?(l(),r("span",q,"Saving...")):(l(),r("span",R,"Save"))],8,$)])])])],32)])]),_:1})],64))}};export{A as default};
