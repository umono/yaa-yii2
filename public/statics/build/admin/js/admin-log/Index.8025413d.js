import{_ as e}from"../TableData/TableData.db97d795.js";import{d as a,H as s,r as t,b as n,w as l,z as r,o as d,e as o}from"../.pnpm/.pnpm.f37eb169.js";import{_ as i}from"../../assets/index.332e1771.js";const m=i(a({name:"AdminLog",components:{TableData:e},setup(){let e=s({name:""});const a=s([{title:"操作",key:"tags",width:200,fixed:"right",NButtons:[{size:"small",emitFunction:"view",text:"查看"}]}]);return{selectedValue:t(null),handle:a,search:e}},methods:{refresh(e){}}}),[["render",function(a,s,t,i,m,h){const u=e,c=r;return d(),n(c,null,{default:l((()=>[o(u,{subHeight:240,search:a.search,ref:"tables",onView:a.refresh,scrollX:1800,url:"admin/api/admin-log/index",handle:a.handle},null,8,["search","onView","handle"])])),_:1})}],["__scopeId","data-v-7dba751d"]]);export{m as default};
