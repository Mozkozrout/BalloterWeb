import{l as d,i as c,v as n,c as s,h as g,E as h,g as y,G as m,al as Q,m as f,q as k}from"./index.0f3dcf3a.js";var $=d({name:"QPage",props:{padding:Boolean,styleFn:Function},setup(e,{slots:r}){const{proxy:{$q:a}}=y(),t=c(m,n);if(t===n)return console.error("QPage needs to be a deep child of QLayout"),n;if(c(Q,n)===n)return console.error("QPage needs to be child of QPageContainer"),n;const l=s(()=>{const i=(t.header.space===!0?t.header.size:0)+(t.footer.space===!0?t.footer.size:0);if(typeof e.styleFn=="function"){const v=t.isContainer.value===!0?t.containerHeight.value:a.screen.height;return e.styleFn(i,v)}return{minHeight:t.isContainer.value===!0?t.containerHeight.value-i+"px":a.screen.height===0?i!==0?`calc(100vh - ${i}px)`:"100vh":a.screen.height-i+"px"}}),o=s(()=>`q-page${e.padding===!0?" q-layout-padding":""}`);return()=>g("main",{class:o.value,style:l.value},h(r.default))}});const p=["text","rect","circle","QBtn","QBadge","QChip","QToolbar","QCheckbox","QRadio","QToggle","QSlider","QRange","QInput","QAvatar"],q=["wave","pulse","pulse-x","pulse-y","fade","blink","none"];var C=d({name:"QSkeleton",props:{...f,tag:{type:String,default:"div"},type:{type:String,validator:e=>p.includes(e),default:"rect"},animation:{type:String,validator:e=>q.includes(e),default:"wave"},animationSpeed:{type:[String,Number],default:1500},square:Boolean,bordered:Boolean,size:String,width:String,height:String},setup(e,{slots:r}){const a=y(),t=k(e,a.proxy.$q),u=s(()=>{const o=e.size!==void 0?[e.size,e.size]:[e.width,e.height];return{"--q-skeleton-speed":`${e.animationSpeed}ms`,width:o[0],height:o[1]}}),l=s(()=>`q-skeleton q-skeleton--${t.value===!0?"dark":"light"} q-skeleton--type-${e.type}`+(e.animation!=="none"?` q-skeleton--anim q-skeleton--anim-${e.animation}`:"")+(e.square===!0?" q-skeleton--square":"")+(e.bordered===!0?" q-skeleton--bordered":""));return()=>g(e.tag,{class:l.value,style:u.value},h(r.default))}});export{C as Q,$ as a};
