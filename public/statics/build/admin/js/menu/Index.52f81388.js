import{_ as e}from"../TableData/TableData.6533d4d6.js";import{d as l,t as a,r as t,b as d,w as s,aj as n,o,e as i,l as u,i as c,U as h,j as r,V as p,A as m,ag as v,y as f,z as w,v as y,aM as _,aN as M,Y as U,ar as b,ad as g,f as x}from"../.pnpm/.pnpm.dd1a9690.js";import{_ as I}from"../../assets/index.b7f5a5ed.js";const k=l({setup(){const e=a("reload");return{isShow:t(!1),isEdit:t(!1),loading:t(!1),model:t({child:[]}),reload:e,deleteMenuIds:[],deletePowerIds:[]}},methods:{async show(e){if(this.isShow=!0,this.isEdit=e.isEdit,e.id){this.model.id=e.id;const{data:l}=await this.$http.get("admin/api/menu/view?id="+e.id);l&&(this.model=l)}else this.model={child:[]}},async submitFunc(){this.loading=!0;const e={...this.model,deleteMenuIds:this.deleteMenuIds,deletePowerIds:this.deletePowerIds},{data:l,msg:a}=await this.$http.post("admin/api/menu/update",e);l&&(window.$message.success(a),this.isShow=!1,this.reload(),await this.$store.dispatch("auth/authentication")),this.loading=!1},addMenu(){const e={name:"未命名菜单"+(this.model.child.length+1),child:[]};this.model.child.push(e)},deleteMenuClose(e){const l=this.model.child.findIndex((l=>l.name===e));~l&&(~this.model.child[l].id&&this.deleteMenuIds.push(this.model.child[l].id),this.model.child.splice(l,1))},deletePowerMenu(e,l){~this.model.child[l].child[e].id&&this.deletePowerIds.push(this.model.child[l].child[e].id),this.model.child[l].child.splice(e,1)}}}),C=u("span",{class:"text-stone-400"},"菜单名称",-1),E=u("span",{class:"text-stone-400"},"名称key",-1),D=u("span",{class:"text-stone-400"},"图标名称",-1),j=u("div",{class:"text-stone-400 p-3 pl-0"},[
r(" 查阅："),
u("a",{href:"https://www.xicons.org/#/",target:"_blank",class:"ext-stone-400"},"xicons")],-1),P=u("span",{class:"text-stone-400"},"显示顺序",-1),S=u("p",null,"⚒️",-1),F=u("span",{class:"text-stone-400"},"菜单名称",-1),$=u("span",{class:"text-stone-400"},"描述",-1),z=u("span",{class:"text-stone-400"},"菜单URL",-1),A=u("thead",null,[
u("tr",{class:"text-stone-400"},[
u("th",null,"权限名称"),
u("th",null,"描述"),
u("th",null,"权限URL"),
u("th",null,"操作")])],-1);const N=I(l({name:"Menu",components:{TableData:e,FormModal:I(k,[["render",function(e,l,a,t,g,x){const I=v,k=f,N=w,T=y,H=_,L=M,R=U,V=b,q=n;return o(),d(q,{show:e.isShow,"onUpdate:show":l[5]||(l[5]=l=>e.isShow=l),width:"58%",placement:"right","auto-focus":!1},{default:s((()=>[i(V,null,{default:s((()=>[i(N,{bordered:!1},{default:s((()=>[i(N,{title:"菜单",class:""},{default:s((()=>[i(k,null,{default:s((()=>[u("div",null,[C,i(I,{value:e.model.name,"onUpdate:value":l[0]||(l[0]=l=>e.model.name=l),placeholder:"菜单"},null,8,["value"])]),u("div",null,[E,i(I,{value:e.model.actionId,"onUpdate:value":l[1]||(l[1]=l=>e.model.actionId=l),placeholder:"menu"},null,8,["value"])]),u("div",null,[D,i(I,{value:e.model.iconName,"onUpdate:value":l[2]||(l[2]=l=>e.model.iconName=l),placeholder:"Home"},null,8,["value"]),j]),u("div",null,[P,i(I,{value:e.model.sort,"onUpdate:value":l[3]||(l[3]=l=>e.model.sort=l),placeholder:"1"},null,8,["value"])])])),_:1})])),_:1}),i(N,{title:"添加子菜单",class:"mt-8"},{default:s((()=>[i(R,{type:"card",addable:"",onAdd:e.addMenu,closable:!0,onClose:e.deleteMenuClose,class:"card-tabs"},{default:s((()=>[(o(!0),c(p,null,h(e.model.child,((l,a)=>(o(),d(L,{name:l.name,tab:l.name},{default:s((()=>[S,u("div",null,[i(k,null,{default:s((()=>[u("div",null,[F,i(I,{value:l.name,"onUpdate:value":e=>l.name=e},null,8,["value","onUpdate:value"])]),u("div",null,[$,i(I,{value:l.typeDes,"onUpdate:value":e=>l.typeDes=e},null,8,["value","onUpdate:value"])]),u("div",null,[z,i(I,{value:l.actionId,"onUpdate:value":e=>l.actionId=e},null,8,["value","onUpdate:value"])])])),_:2},1024)]),u("p",null,[r("⛏️ "),i(T,{strong:"",tertiary:"",type:"success",size:"small",onClick:e=>l.child.push({})},{default:s((()=>[r(" 添加权限")])),_:2},1032,["onClick"])]),i(H,{"single-line":!1},{default:s((()=>[A,u("tbody",null,[(o(!0),c(p,null,h(l.child,((l,t)=>(o(),c("tr",{key:t+"_power_child"},[u("td",null,[i(I,{value:l.name,"onUpdate:value":e=>l.name=e,placeholder:"模板创建"},null,8,["value","onUpdate:value"])]),u("td",null,[i(I,{value:l.typeDes,"onUpdate:value":e=>l.typeDes=e,placeholder:"模板创建权限，可以访问url数据"},null,8,["value","onUpdate:value"])]),u("td",null,[i(I,{value:l.actionId,"onUpdate:value":e=>l.actionId=e,placeholder:"template/delete"},null,8,["value","onUpdate:value"])]),u("td",null,[i(T,{strong:"",tertiary:"",type:"error",size:"tiny",onClick:l=>e.deletePowerMenu(t,a)},{default:s((()=>[r(" 删除 ")])),_:2},1032,["onClick"])])])))),128))])])),_:2},1024)])),_:2},1032,["name","tab"])))),256))])),_:1},8,["onAdd","onClose"])])),_:1}),e.isEdit?(o(),d(k,{key:0,class:"mt-8",justify:"end"},{default:s((()=>[i(T,{type:"default",onClick:l[4]||(l[4]=l=>e.isShow=!1),strong:"",secondary:""},{default:s((()=>[r("取消")])),_:1}),i(T,{type:"primary",onClick:e.submitFunc,loading:e.loading},{default:s((()=>[r("保存")])),_:1},8,["onClick","loading"])])),_:1})):m("",!0)])),_:1})])),_:1})])),_:1},8,["show"])}]])},setup:()=>({search:g({name:""})})}),[["render",function(l,a,t,d,n,u){const h=y,p=v,m=e,f=x("FormModal");return o(),c("div",null,[i(m,{subHeight:240,search:l.search,ref:"tables",onView:a[2]||(a[2]=e=>l.openModal({id:e.id,isEdit:!1},"formModal")),onEdit:a[3]||(a[3]=e=>l.openModal({id:e.id,isEdit:!0},"formModal")),url:"admin/api/menu/index",handle:l._handleBtn},{btn:s((()=>[i(h,{quaternary:"",onClick:a[0]||(a[0]=e=>l.openModal({id:null,isEdit:!0},"formModal"))},{default:s((()=>[r("创建")])),_:1})])),default:s((()=>[i(p,{value:l.search.name,"onUpdate:value":a[1]||(a[1]=e=>l.search.name=e),filterable:"",placeholder:"菜单名称"},null,8,["value"])])),_:1},8,["search","handle"]),i(f,{ref:"formModal"},null,512)])}]]);export{N as default};
