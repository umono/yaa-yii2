var I=Object.defineProperty;var O=(e,t,l)=>t in e?I(e,t,{enumerable:!0,configurable:!0,writable:!0,value:l}):e[t]=l;var C=(e,t,l)=>(O(e,typeof t!="symbol"?t+"":t,l),l);import{d as P,a6 as V,a as K,r as m,B as S,y as F,a7 as U,b as $,w as o,a4 as j,o as v,e as n,a8 as k,j as w,l as M,i as q,E as J,F as L,a9 as X,C as G,aa as Q,t as z,ab as W,ac as Y,q as T,f as D,ad as Z,a5 as x,ae as B,N as ee,I as te,af as ae,ag as oe,ah as ne,ai as le,aj as se,v as re,n as ie,ak as ue,al as de}from"./vendor.ea902574.js";import{C as N,_ as H,R as pe}from"./index.19b55c5b.js";const ce=P({components:{Draggable:V},props:{toModel:{default:null,type:Object},toUrl:{default:"",type:String},showModal:{default:!1,type:Boolean},tableTitle:{default:[],type:Array},attribute:{type:Array,default:[]}},setup(e,t){const l=K();let u=m(""),g=m({}),b=m(!1),f=m(l.getters["tableStore/getSelectDragArr"]);u.value=e.toUrl,g.value=e.toModel,b.value=e.showModal,S(()=>e.showModal,s=>{b.value=s});const d=N.Encrypt(e.toUrl),_=F({animation:200,group:"description",disabled:!1,ghostClass:"ghost"});let a=F({drag:!1,dragArr:[]});return S(()=>e.tableTitle,(s,i)=>{const h=[];s.forEach(p=>{h.push(p.prop)}),f.value=h}),S(b,s=>{if(s){let i=window.localStorage.getItem(d);if(i&&(i=JSON.parse(i),i&&i.dragArr.length>0)){const h=[];i.dragArr.forEach(p=>{h.push(p.prop)}),console.log("\u5F53\u524D\u9009\u62E9",u.value,h),f.value=h,a.dragArr=i.dragArr}}t.emit("update:showModal",s)}),S(()=>f.value,(s,i)=>{const h=U(s,i),p=U(i,s);e.attribute.forEach(y=>{h.forEach(r=>{y.prop==r&&a.dragArr.push(y)})}),p.forEach(y=>{a.dragArr.forEach((r,c)=>{y==r.prop&&a.dragArr.splice(c,1)})})}),{toUrl:u,toModel:g,showModal:b,loading:m(!1),dragOptions:_,dragData:a,selectArr:f,name:d}},methods:{async onSubmit(){const e={dragArr:this.dragData.dragArr},t=JSON.stringify(e);window.localStorage.setItem(this.name,t),this.$emit("updateSelect",this.dragData.dragArr),this.showModal=!1},close(){if(this.loading)return!1;this.showModal=!1}}});const ge={class:"custom-card"};function _e(e,t,l,u,g,b){const f=Q,d=z,_=W,a=Y,s=T,i=D("draggable"),h=Z,p=x,y=j;return v(),$(y,{show:e.showModal,"onUpdate:show":t[4]||(t[4]=r=>e.showModal=r),placement:"left",width:"268"},{default:o(()=>[n(p,{title:"\u7B5B\u9009"},{footer:o(()=>[k(e.$slots,"footer",{},()=>[n(d,null,{default:o(()=>[n(s,{onClick:e.close,strong:"",secondary:""},{default:o(()=>[w("\u53D6\u6D88")]),_:1},8,["onClick"]),n(s,{type:"primary",onClick:e.onSubmit,loading:e.loading,strong:"",secondary:""},{default:o(()=>[w("\u786E\u5B9A")]),_:1},8,["onClick","loading"])]),_:1})],!0)]),default:o(()=>[M("div",ge,[n(h,{"arrow-placement":"right"},{default:o(()=>[n(a,{title:"\u81EA\u9009\u62E9\u5217",name:"1"},{default:o(()=>[n(_,{value:e.selectArr,"onUpdate:value":t[0]||(t[0]=r=>e.selectArr=r)},{default:o(()=>[n(d,{"item-style":"display: flex;"},{default:o(()=>[(v(!0),q(L,null,J(e.attribute,r=>(v(),$(f,{key:r.prop,label:r.label,value:r.prop},null,8,["label","value"]))),128))]),_:1})]),_:1},8,["value"])]),_:1}),n(a,{title:"\u663E\u793A\u987A\u5E8F",name:"2"},{default:o(()=>[n(d,null,{default:o(()=>[n(i,X({class:"wrapper",modelValue:e.dragData.dragArr,"onUpdate:modelValue":t[1]||(t[1]=r=>e.dragData.dragArr=r)},e.dragOptions,{onStart:t[2]||(t[2]=r=>e.dragData.drag=!0),onEnd:t[3]||(t[3]=r=>{e.dragData.drag=!1}),"item-key":"prop"}),{item:o(({element:r})=>[n(s,{tertiary:"",class:"drag-bt"},{default:o(()=>[w(G(r.label),1)]),_:2},1024)]),_:1},16,["modelValue"])]),_:1})]),_:1}),n(a,{title:"\u5176\u4ED6\u64CD\u4F5C",name:"3"},{default:o(()=>[n(d,{class:"action-btn"},{default:o(()=>[n(s,{tertiary:""},{default:o(()=>[w(" \u5BFC\u51FA\u6240\u9009 ")]),_:1}),n(s,{tertiary:"",type:"primary"},{default:o(()=>[w(" \u5BFC\u51FA\u6240\u6709 ")]),_:1}),n(s,{tertiary:"",type:"error"},{default:o(()=>[w(" \u5220\u9664\u6240\u9009 ")]),_:1})]),_:1})]),_:1})]),_:1})])]),_:3})]),_:3},8,["show"])}const R=H(ce,[["render",_e],["__scopeId","data-v-c35acc95"]]);class he{constructor(t){C(this,"getDataLists",async(t,l)=>await pe.get(t,l));C(this,"pagination",F({page:1,pageSize:20,pageCount:0,showSizePicker:!0,pageSizes:[20,50,100],onChange:t=>{this.pagination.page=t},onUpdatePageSize:t=>{this.pagination.pageSize=t,this.pagination.page=1}}));C(this,"config",{url:"",handle:[]});const l=this.config;this.config={...l,...t}}async getTableData(t=null){const l=this.pagination,u={page:l.page,limit:l.pageSize,...t},{data:g}=await this.getDataLists(this.config.url,u);if(g&&g.list){const b=g.attribute,f=g.tabTitle,d=Math.ceil(g.list.count/this.pagination.pageSize);this.pagination.pageCount=d;const _=[];return this.config.isSelection&&_.push({type:"selection",fixed:"left"}),f.forEach(a=>{a.template=="image"?_.push({title:a.label,key:a.prop,width:a.width,ellipsis:{tooltip:!0},sorter:!0,render:s=>B(ee,{width:30,height:30,src:s[a.prop]})}):_.push({title:a.label,key:a.prop,width:a.width,ellipsis:{tooltip:!0},sorter:!0})}),this.config.handle.length>0&&this.config.handle.forEach(a=>{_.push(a)}),{columns:_,attribute:b,tabTitle:g.tabTitle,lists:g.list.data,loading:!1,paginationReactive:l,listCount:d}}}selectRowArray(t){console.log("selectArray",t)}handlePageChange(t){console.log("currentPage",t)}handleFiltersChange(t){console.log("filters",t)}}const fe=he,me=P({components:{Icon:te,Filter24Filled:ae,Search24Filled:oe,TablePop:R},props:{size:{default:"medium",type:String},search:{default:{},type:Object},url:{default:"",type:String},minHeight:{default:200,type:Number},maxHeight:{default:600,type:Number},handle:{default:[],type:Array},subHeight:{default:0,type:Number},isSelection:{default:!0,type:Boolean},bordered:{default:!0,type:Boolean},scrollX:{default:1800,type:Number}},setup(e,t){const l=e.handle;l.forEach(c=>{c.render=E=>c.NButtons.map(A=>B(T,{style:{marginRight:"6px"},size:A.size,type:A.type,secondary:!0,onClick:()=>{t.emit(A.emitFunction,E)}},{default:()=>A.text}))});const u=new fe({url:e.url,handle:l,isSelection:e.isSelection});let g=m([]),b=m([]),f=m([]),d=m([]),_=m(0),a=m(!0),s=u.pagination,i=e.search;i.select=[];const h=N.Encrypt(e.url);let p=window.localStorage.getItem(h);if(p&&(p=JSON.parse(p),p&&p.dragArr.length>0)){const c=[];p.dragArr.forEach(E=>{c.push(E.prop)}),i.select=c}const y=async()=>{a.value=!0;const c=await u.getTableData(i);c&&(g.value=c.lists,d.value=c.columns,_.value=c.listCount,b.value=c.attribute,f.value=c.tabTitle),a.value=!1};ne(y),S([()=>s.page,()=>s.pageSize,()=>i],y,{deep:!0});let r=m(window.innerHeight-75);return window.onresize=()=>(()=>{r.value=window.innerHeight-75})(),{search:i,tableHelper:u,loading:a,rowKey:c=>c.id,pagination:s,lists:g,columns:d,listCount:_,selectRowArray:u.selectRowArray,handlePageChange:u.handlePageChange,handleFiltersChange:u.handleFiltersChange,screenHeight:r,useSlot:!!le().default,showPopModal:m(!1),attribute:b,tableTitle:f}},methods:{handleSorterChange(e){this.search._order_by=e.columnKey+"-"+(e.order=="descend"?"desc":"ascending")},updateSelect(e){const t=this.search.select,l=[];e.forEach(u=>{l.push(u.prop)}),se(l,t)||(this.search.select=l)}}});const be={class:"table-head-box"},ye={class:"button-group"};function we(e,t,l,u,g,b){const f=D("Filter24Filled"),d=D("Icon"),_=T,a=D("Search24Filled"),s=z,i=ue,h=de,p=R,y=re;return v(),$(y,{class:"table-data-box"},{default:o(()=>[M("div",be,[M("div",ye,[n(_,{quaternary:"",onClick:t[0]||(t[0]=r=>e.showPopModal=!0)},{default:o(()=>[n(d,null,{default:o(()=>[n(f)]),_:1})]),_:1}),k(e.$slots,"btn",{},void 0,!0)]),e.useSlot?(v(),$(s,{key:0,class:"slot-head"},{default:o(()=>[k(e.$slots,"default",{},void 0,!0),n(_,{strong:"",secondary:"",circle:""},{default:o(()=>[n(d,null,{default:o(()=>[n(a)]),_:1})]),_:1})]),_:3})):ie("",!0)]),n(h,null,{default:o(()=>[n(i,{"max-height":e.screenHeight-e.subHeight,bordered:e.bordered,size:e.size,ref:"table",loading:e.loading,remote:"",columns:e.columns,data:e.lists,"row-key":e.rowKey,"scroll-x":e.scrollX,pagination:e.pagination,"onUpdate:page":e.handlePageChange,"onUpdate:checkedRowKeys":e.selectRowArray,"onUpdate:sorter":e.handleSorterChange,"onUpdate:filters":e.handleFiltersChange},null,8,["max-height","bordered","size","loading","columns","data","row-key","scroll-x","pagination","onUpdate:page","onUpdate:checkedRowKeys","onUpdate:sorter","onUpdate:filters"])]),_:1}),n(p,{ref:"tablePop_"+e.url,showModal:e.showPopModal,"onUpdate:showModal":t[1]||(t[1]=r=>e.showPopModal=r),attribute:e.attribute,toUrl:e.url,tableTitle:e.tableTitle,onUpdateSelect:e.updateSelect},null,8,["showModal","attribute","toUrl","tableTitle","onUpdateSelect"])]),_:3})}const De=H(me,[["render",we],["__scopeId","data-v-47bc34da"]]);export{De as _};
