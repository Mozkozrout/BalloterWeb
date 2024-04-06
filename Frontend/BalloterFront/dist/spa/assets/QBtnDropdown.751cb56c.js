import{l as y,m as Q,as as M,q as H,at as I,c as n,h as u,ar as V,g as D,E as x,au as A,av as z,r as k,aw as O,ax as j,w as $,o as L,M as R,Z as S,ag as N}from"./index.0f3dcf3a.js";import{a as F}from"./QSelect.63be3276.js";const G={xs:2,sm:4,md:6,lg:10,xl:14};function C(e,l,t){return{transform:l===!0?`translateX(${t.lang.rtl===!0?"-":""}100%) scale3d(${-e},1,1)`:`scale3d(${e},1,1)`}}var Z=y({name:"QLinearProgress",props:{...Q,...M,value:{type:Number,default:0},buffer:Number,color:String,trackColor:String,reverse:Boolean,stripe:Boolean,indeterminate:Boolean,query:Boolean,rounded:Boolean,animationSpeed:{type:[String,Number],default:2100},instantFeedback:Boolean},setup(e,{slots:l}){const{proxy:t}=D(),s=H(e,t.$q),r=I(e,G),o=n(()=>e.indeterminate===!0||e.query===!0),d=n(()=>e.reverse!==e.query),c=n(()=>({...r.value!==null?r.value:{},"--q-linear-progress-speed":`${e.animationSpeed}ms`})),b=n(()=>"q-linear-progress"+(e.color!==void 0?` text-${e.color}`:"")+(e.reverse===!0||e.query===!0?" q-linear-progress--reverse":"")+(e.rounded===!0?" rounded-borders":"")),v=n(()=>C(e.buffer!==void 0?e.buffer:1,d.value,t.$q)),i=n(()=>`with${e.instantFeedback===!0?"out":""}-transition`),g=n(()=>`q-linear-progress__track absolute-full q-linear-progress__track--${i.value} q-linear-progress__track--${s.value===!0?"dark":"light"}`+(e.trackColor!==void 0?` bg-${e.trackColor}`:"")),m=n(()=>C(o.value===!0?1:e.value,d.value,t.$q)),w=n(()=>`q-linear-progress__model absolute-full q-linear-progress__model--${i.value} q-linear-progress__model--${o.value===!0?"in":""}determinate`),h=n(()=>({width:`${e.value*100}%`})),q=n(()=>`q-linear-progress__stripe absolute-${e.reverse===!0?"right":"left"} q-linear-progress__stripe--${i.value}`);return()=>{const f=[u("div",{class:g.value,style:v.value}),u("div",{class:w.value,style:m.value})];return e.stripe===!0&&o.value===!1&&f.push(u("div",{class:q.value,style:h.value})),u("div",{class:b.value,style:c.value,role:"progressbar","aria-valuemin":0,"aria-valuemax":1,"aria-valuenow":e.indeterminate===!0?void 0:e.value},V(l.default,f))}}}),W=y({name:"QBtnGroup",props:{unelevated:Boolean,outline:Boolean,flat:Boolean,rounded:Boolean,square:Boolean,push:Boolean,stretch:Boolean,glossy:Boolean,spread:Boolean},setup(e,{slots:l}){const t=n(()=>{const s=["unelevated","outline","flat","rounded","square","push","stretch","glossy"].filter(r=>e[r]===!0).map(r=>`q-btn-group--${r}`).join(" ");return`q-btn-group row no-wrap${s.length!==0?" "+s:""}`+(e.spread===!0?" q-btn-group--spread":" inline")});return()=>u("div",{class:t.value},x(l.default))}});const E=Object.keys(A),T=e=>E.reduce((l,t)=>{const s=e[t];return s!==void 0&&(l[t]=s),l},{});var J=y({name:"QBtnDropdown",props:{...A,...z,modelValue:Boolean,split:Boolean,dropdownIcon:String,contentClass:[Array,String,Object],contentStyle:[Array,String,Object],cover:Boolean,persistent:Boolean,noRouteDismiss:Boolean,autoClose:Boolean,menuAnchor:{type:String,default:"bottom end"},menuSelf:{type:String,default:"top end"},menuOffset:Array,disableMainBtn:Boolean,disableDropdown:Boolean,noIconAnimation:Boolean,toggleAriaLabel:String},emits:["update:modelValue","click","beforeShow","show","beforeHide","hide"],setup(e,{slots:l,emit:t}){const{proxy:s}=D(),r=k(e.modelValue),o=k(null),d=O(),c=n(()=>{const a={"aria-expanded":r.value===!0?"true":"false","aria-haspopup":"true","aria-controls":d.value,"aria-label":e.toggleAriaLabel||s.$q.lang.label[r.value===!0?"collapse":"expand"](e.label)};return(e.disable===!0||e.split===!1&&e.disableMainBtn===!0||e.disableDropdown===!0)&&(a["aria-disabled"]="true"),a}),b=n(()=>"q-btn-dropdown__arrow"+(r.value===!0&&e.noIconAnimation===!1?" rotate-180":"")+(e.split===!1?" q-btn-dropdown__arrow-container":"")),v=n(()=>j(e)),i=n(()=>T(e));$(()=>e.modelValue,a=>{o.value!==null&&o.value[a?"show":"hide"]()}),$(()=>e.split,B);function g(a){r.value=!0,t("beforeShow",a)}function m(a){t("show",a),t("update:modelValue",!0)}function w(a){r.value=!1,t("beforeHide",a)}function h(a){t("hide",a),t("update:modelValue",!1)}function q(a){t("click",a)}function f(a){N(a),B(),t("click",a)}function P(a){o.value!==null&&o.value.toggle(a)}function _(a){o.value!==null&&o.value.show(a)}function B(a){o.value!==null&&o.value.hide(a)}return Object.assign(s,{show:_,hide:B,toggle:P}),L(()=>{e.modelValue===!0&&_()}),()=>{const a=[u(R,{class:b.value,name:e.dropdownIcon||s.$q.iconSet.arrow.dropdown})];return e.disableDropdown!==!0&&a.push(u(F,{ref:o,id:d.value,class:e.contentClass,style:e.contentStyle,cover:e.cover,fit:!0,persistent:e.persistent,noRouteDismiss:e.noRouteDismiss,autoClose:e.autoClose,anchor:e.menuAnchor,self:e.menuSelf,offset:e.menuOffset,separateClosePopup:!0,transitionShow:e.transitionShow,transitionHide:e.transitionHide,transitionDuration:e.transitionDuration,onBeforeShow:g,onShow:m,onBeforeHide:w,onHide:h},l.default)),e.split===!1?u(S,{class:"q-btn-dropdown q-btn-dropdown--simple",...i.value,...c.value,disable:e.disable===!0||e.disableMainBtn===!0,noWrap:!0,round:!1,onClick:q},{default:()=>x(l.label,[]).concat(a),loading:l.loading}):u(W,{class:"q-btn-dropdown q-btn-dropdown--split no-wrap q-btn-item",rounded:e.rounded,square:e.square,...v.value,glossy:e.glossy,stretch:e.stretch},()=>[u(S,{class:"q-btn-dropdown--current",...i.value,disable:e.disable===!0||e.disableMainBtn===!0,noWrap:!0,round:!1,onClick:f},{default:l.label,loading:l.loading}),u(S,{class:"q-btn-dropdown__arrow-container q-anchor--skip",...c.value,...v.value,disable:e.disable===!0||e.disableDropdown===!0,rounded:e.rounded,color:e.color,textColor:e.textColor,dense:e.dense,size:e.size,padding:e.padding,ripple:e.ripple},()=>a)])}}});export{J as Q,Z as a};