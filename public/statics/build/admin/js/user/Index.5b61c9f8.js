import{d as a,r as n,am as s,an as t,B as e,i as d,l as r,ao as i,o as l,p as c,k as v,as as u,F as b,E as p,b as o,x as m,f as k,e as f,w as g,q as h,j as x}from"../.pnpm/.pnpm.ea5fa7c5.js";import{_ as M}from"../../assets/index.013a048f.js";const I=a({props:["number","index","numberArr"],setup(a){a.index;const d=n(0);let r=null,i=null;const l=s((async a=>{const n=40*a;d.value=-30,r=setInterval((a=>{d.value+=6,d.value>n+30&&(i=setInterval((a=>{d.value-=1,d.value==n&&(d.value=n,clearInterval(i))}),1),clearInterval(r))}),1)}),1e3,{leading:!0,trailing:!1});return t((()=>{l.cancel(),clearInterval(r),clearInterval(i)})),e((()=>a.number),(a=>{l(a)})),{number:d}}}),_=a=>(c("data-v-53d2b454"),a=a(),v(),a),A={class:"ticker-column-container"},j=[u('<div class="ticker-digit" data-v-53d2b454><span data-v-53d2b454>9</span></div><div class="ticker-digit" data-v-53d2b454><span data-v-53d2b454>8</span></div><div class="ticker-digit" data-v-53d2b454><span data-v-53d2b454>7</span></div><div class="ticker-digit" data-v-53d2b454><span data-v-53d2b454>6</span></div><div class="ticker-digit" data-v-53d2b454><span data-v-53d2b454>5</span></div><div class="ticker-digit" data-v-53d2b454><span data-v-53d2b454>4</span></div><div class="ticker-digit" data-v-53d2b454><span data-v-53d2b454>3</span></div><div class="ticker-digit" data-v-53d2b454><span data-v-53d2b454>2</span></div><div class="ticker-digit" data-v-53d2b454><span data-v-53d2b454>1</span></div><div class="ticker-digit" data-v-53d2b454><span data-v-53d2b454>0</span></div>',10)],y=_((()=>r("span",{class:"number-placeholder"},"0",-1)));const J=a({props:["number","numberArr"],components:{numberJump:M(I,[["render",function(a,n,s,t,e,c){return l(),d("div",A,[r("div",{class:"ticker-column",style:i(`transform: translateY(${a.number}px) translateZ(00px);`)},j,4),y])}],["__scopeId","data-v-53d2b454"]])},setup:a=>({number:a.number,numberValue:a.numberArr})}),w={class:"jump-number-box"},C={class:"font-200 inline-block"},E={class:"ticker-view",style:{transform:"none","transform-origin":"50% 50% 0px"}};const V=M(J,[["render",function(a,n,s,t,e,i){const c=k("numberJump");return l(),d("div",w,[r("h1",null,[r("span",C,[r("div",E,[(l(!0),d(b,null,p(a.number,((n,s)=>(l(),o(c,{number:a.numberValue[s],index:s,class:m("sort-"+s)},null,8,["number","index","class"])))),256))])])])])}],["__scopeId","data-v-dcbf3fd0"]]);const q=M(a({name:"USER",components:{NumberJump:V},setup(){const a=n([1,3,0,5,2]);return{labelArr:a,tttt(){a.value[0]=Math.ceil(9*Math.random()),a.value[1]=Math.ceil(9*Math.random()),a.value[2]=Math.ceil(9*Math.random()),a.value[3]=Math.ceil(9*Math.random()),a.value[4]=Math.ceil(9*Math.random())}}}}),[["render",function(a,n,s,t,e,r){const i=h,c=V;return l(),d(b,null,[f(i,{onClick:a.tttt},{default:g((()=>[x("测试")])),_:1},8,["onClick"]),f(c,{number:5,numberArr:a.labelArr},null,8,["numberArr"])],64)}],["__scopeId","data-v-29eb382b"]]);export{q as default};
