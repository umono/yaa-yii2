import{d as _,r as m,aw as h,ax as g,H as $,i as l,l as o,ay as k,o as c,p as x,k as I,aC as M,J as b,Q as y,b as A,A as V,f as C,e as v,w as N,v as w,j as B}from"../.pnpm/.pnpm.11b07c8d.js";import{_ as p}from"../../assets/index.cc48ff87.js";const J=_({props:["number","index","numberArr"],setup(e){e.index;const a=m(0);let t=null,s=null;const r=h(async d=>{const n=d*40;a.value=-30,t=setInterval(u=>{a.value+=6,a.value>n+30&&(s=setInterval(i=>{a.value-=1,a.value==n&&(a.value=n,clearInterval(s))},1),clearInterval(t))},1)},1e3,{leading:!0,trailing:!1});return g(()=>{r.cancel(),clearInterval(t),clearInterval(s)}),$(()=>e.number,d=>{r(d)}),{number:a}}});const S=e=>(x("data-v-53d2b454"),e=e(),I(),e),j={class:"ticker-column-container"},z=M('<div class="ticker-digit" data-v-53d2b454><span data-v-53d2b454>9</span></div><div class="ticker-digit" data-v-53d2b454><span data-v-53d2b454>8</span></div><div class="ticker-digit" data-v-53d2b454><span data-v-53d2b454>7</span></div><div class="ticker-digit" data-v-53d2b454><span data-v-53d2b454>6</span></div><div class="ticker-digit" data-v-53d2b454><span data-v-53d2b454>5</span></div><div class="ticker-digit" data-v-53d2b454><span data-v-53d2b454>4</span></div><div class="ticker-digit" data-v-53d2b454><span data-v-53d2b454>3</span></div><div class="ticker-digit" data-v-53d2b454><span data-v-53d2b454>2</span></div><div class="ticker-digit" data-v-53d2b454><span data-v-53d2b454>1</span></div><div class="ticker-digit" data-v-53d2b454><span data-v-53d2b454>0</span></div>',10),D=[z],E=S(()=>o("span",{class:"number-placeholder"},"0",-1));function U(e,a,t,s,r,d){return c(),l("div",j,[o("div",{class:"ticker-column",style:k(`transform: translateY(${e.number}px) translateZ(00px);`)},D,4),E])}const F=p(J,[["render",U],["__scopeId","data-v-53d2b454"]]),H=_({props:["number","numberArr"],components:{numberJump:F},setup(e){const a=e.number,t=e.numberArr;return{number:a,numberValue:t}}});const L={class:"jump-number-box"},Q={class:"font-200 inline-block"},R={class:"ticker-view",style:{transform:"none","transform-origin":"50% 50% 0px"}};function T(e,a,t,s,r,d){const n=C("numberJump");return c(),l("div",L,[o("h1",null,[o("span",Q,[o("div",R,[(c(!0),l(b,null,y(e.number,(u,i)=>(c(),A(n,{number:e.numberValue[i],index:i,class:V("sort-"+i)},null,8,["number","index","class"]))),256))])])])])}const f=p(H,[["render",T],["__scopeId","data-v-dcbf3fd0"]]),Y=_({name:"USER",components:{NumberJump:f},setup(){const e=m([1,3,0,5,2]);return{labelArr:e,tttt(){e.value[0]=Math.ceil(Math.random()*9),e.value[1]=Math.ceil(Math.random()*9),e.value[2]=Math.ceil(Math.random()*9),e.value[3]=Math.ceil(Math.random()*9),e.value[4]=Math.ceil(Math.random()*9),console.log("go",e.value)}}}});function Z(e,a,t,s,r,d){const n=w,u=f;return c(),l(b,null,[v(n,{onClick:e.tttt},{default:N(()=>[B("\u6D4B\u8BD5")]),_:1},8,["onClick"]),v(u,{number:5,numberArr:e.labelArr},null,8,["numberArr"])],64)}const K=p(Y,[["render",Z],["__scopeId","data-v-29eb382b"]]);export{K as default};
