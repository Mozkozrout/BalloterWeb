import{h as n,l as B,bk as U,bl as z,r as m,c as P,w as v,aU as O,aT as V,A as _,o as j,aa as F,E as W,a9 as $,bm as b,z as I,an as C,bn as T,am as G,bo as A,aR as J,g as K}from"./index.0f3dcf3a.js";const X=[n("circle",{cx:"15",cy:"15",r:"15"},[n("animate",{attributeName:"r",from:"15",to:"15",begin:"0s",dur:"0.8s",values:"15;9;15",calcMode:"linear",repeatCount:"indefinite"}),n("animate",{attributeName:"fill-opacity",from:"1",to:"1",begin:"0s",dur:"0.8s",values:"1;.5;1",calcMode:"linear",repeatCount:"indefinite"})]),n("circle",{cx:"60",cy:"15",r:"9","fill-opacity":".3"},[n("animate",{attributeName:"r",from:"9",to:"9",begin:"0s",dur:"0.8s",values:"9;15;9",calcMode:"linear",repeatCount:"indefinite"}),n("animate",{attributeName:"fill-opacity",from:".5",to:".5",begin:"0s",dur:"0.8s",values:".5;1;.5",calcMode:"linear",repeatCount:"indefinite"})]),n("circle",{cx:"105",cy:"15",r:"15"},[n("animate",{attributeName:"r",from:"15",to:"15",begin:"0s",dur:"0.8s",values:"15;9;15",calcMode:"linear",repeatCount:"indefinite"}),n("animate",{attributeName:"fill-opacity",from:"1",to:"1",begin:"0s",dur:"0.8s",values:"1;.5;1",calcMode:"linear",repeatCount:"indefinite"})])];var Z=B({name:"QSpinnerDots",props:U,setup(a){const{cSize:u,classes:h}=z(a);return()=>n("svg",{class:h.value,fill:"currentColor",width:u.value,height:u.value,viewBox:"0 0 120 30",xmlns:"http://www.w3.org/2000/svg"},X)}});const{passive:o}=$;var ee=B({name:"QInfiniteScroll",props:{offset:{type:Number,default:500},debounce:{type:[String,Number],default:100},scrollTarget:{default:void 0},initialIndex:Number,disable:Boolean,reverse:Boolean},emits:["load"],setup(a,{slots:u,emit:h}){const s=m(!1),l=m(!0),d=m(null),S=m(null);let g=a.initialIndex||0,e,i;const D=P(()=>"q-infinite-scroll__loading"+(s.value===!0?"":" invisible"));function c(){if(a.disable===!0||s.value===!0||l.value===!1)return;const t=b(e),r=C(e),f=A(e);a.reverse===!1?Math.round(r+f+a.offset)>=Math.round(t)&&y():Math.round(r)<=a.offset&&y()}function y(){if(a.disable===!0||s.value===!0||l.value===!1)return;g++,s.value=!0;const t=b(e);h("load",g,r=>{l.value===!0&&(s.value=!1,I(()=>{if(a.reverse===!0){const f=b(e),q=C(e),R=f-t;T(e,q+R)}r===!0?x():d.value&&d.value.closest("body")&&i()}))})}function H(){g=0}function w(){l.value===!1&&(l.value=!0,e.addEventListener("scroll",i,o)),c()}function x(){l.value===!0&&(l.value=!1,s.value=!1,e.removeEventListener("scroll",i,o),i!==void 0&&i.cancel!==void 0&&i.cancel())}function N(){if(e&&l.value===!0&&e.removeEventListener("scroll",i,o),e=G(d.value,a.scrollTarget),l.value===!0){if(e.addEventListener("scroll",i,o),a.reverse===!0){const t=b(e),r=A(e);T(e,t-r)}c()}}function Q(t){g=t}function L(t){t=parseInt(t,10);const r=i;i=t<=0?c:J(c,isNaN(t)===!0?100:t),e&&l.value===!0&&(r!==void 0&&e.removeEventListener("scroll",r,o),e.addEventListener("scroll",i,o))}function E(t){if(M.value===!0){if(S.value===null){t!==!0&&I(()=>{E(!0)});return}const r=`${s.value===!0?"un":""}pauseAnimations`;Array.from(S.value.getElementsByTagName("svg")).forEach(f=>{f[r]()})}}const M=P(()=>a.disable!==!0&&l.value===!0);v([s,M],()=>{E()}),v(()=>a.disable,t=>{t===!0?x():w()}),v(()=>a.reverse,()=>{s.value===!1&&l.value===!0&&c()}),v(()=>a.scrollTarget,N),v(()=>a.debounce,L);let p=!1;O(()=>{p!==!1&&e&&T(e,p)}),V(()=>{p=e?C(e):!1}),_(()=>{l.value===!0&&e.removeEventListener("scroll",i,o)}),j(()=>{L(a.debounce),N(),s.value===!1&&E()});const k=K();return Object.assign(k.proxy,{poll:()=>{i!==void 0&&i()},trigger:y,stop:x,reset:H,resume:w,setIndex:Q,updateScrollTarget:N}),()=>{const t=F(u.default,[]);return M.value===!0&&t[a.reverse===!1?"push":"unshift"](n("div",{ref:S,class:D.value},W(u.loading))),n("div",{class:"q-infinite-scroll",ref:d},t)}}});export{ee as Q,Z as a};