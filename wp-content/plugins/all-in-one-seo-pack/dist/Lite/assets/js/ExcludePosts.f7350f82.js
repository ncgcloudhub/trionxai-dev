import{b}from"./links.d8ef3c22.js";import{B as v,a as O}from"./Caret.11ded1aa.js";import{r as p,o as k,c as C,d as a,w as r,g as _,t as o,a as n,i as m}from"./vue.runtime.esm-bundler.0bc3eabf.js";import{b as T}from"./index.888aa896.js";import{_ as S}from"./_plugin-vue_export-helper.8823f7c1.js";/* empty css                                            *//* empty css                                              */import"./default-i18n.3881921e.js";import"./constants.d0e2b74f.js";import{J as $}from"./JsonValues.870a4901.js";import"./TruSeoHighlighter.f41d03f0.js";/* empty css                                              */import{S as B}from"./AddPlus.7ed7a3cc.js";import{S as V}from"./External.88ec9b3a.js";const L={setup(){return{optionsStore:b()}},components:{BaseButton:v,BaseSelect:T,SvgAddPlus:B,SvgClose:O,SvgExternal:V},mixins:[$],props:{options:{type:Object,required:!0},type:{type:String,required:!0}},data(){return{excludeOptions:[],strings:{typeToSearch:this.$t.__("Type to search...",this.$td),noOptionsPosts:this.$t.__("Begin typing a post ID, title or slug to search...",this.$td),noOptionsTerms:this.$t.__("Begin typing a term ID or name to search...",this.$td),noResult:this.$t.__("No results found for your search. Try again!",this.$td),clear:this.$t.__("Clear",this.$td),id:this.$t.__("ID",this.$td),type:this.$t.__("Type",this.$td)}}},computed:{optionName:{get(){return this.type==="posts"?this.options.excludePosts:this.options.excludeTerms},set(e){if(this.type==="posts"){this.options.excludePosts=e;return}this.options.excludeTerms=e}},noOptions(){return this.type==="posts"?this.strings.noOptionsPosts:this.strings.noOptionsTerms}},methods:{processGetObjects(e){return this.optionsStore.getObjects({query:e,type:this.type}).then(s=>{this.excludeOptions=s.body.objects})},getOptionTitle(e,s){const c=new RegExp(`(${s})`,"gi");return e.replace(c,'<span class="search-term">$1</span>')},searchableLabel({value:e,label:s,slug:c}){return`${e} ${s} ${c}`}}},N={class:"aioseo-exclude-posts"},P={class:"option"},j=["innerHTML"],w={class:"option-details"},E=["href","onClick"],R={class:"multiselect__tag"},A={class:"multiselect__tag-value"},D=["onClick"];function J(e,s,c,q,l,i){const h=p("svg-add-plus"),d=p("base-button"),g=p("svg-external"),y=p("svg-close"),x=p("base-select");return k(),C("div",N,[a(x,{options:l.excludeOptions,"ajax-search":i.processGetObjects,customLabel:i.searchableLabel,size:"medium",multiple:"",modelValue:e.getJsonValues(i.optionName),"onUpdate:modelValue":s[0]||(s[0]=t=>i.optionName=e.setJsonValues(t)),placeholder:l.strings.typeToSearch},{noOptions:r(()=>[_(o(i.noOptions),1)]),noResult:r(()=>[_(o(l.strings.noResult),1)]),caret:r(({toggle:t})=>[a(d,{class:"multiselect-toggle",style:{padding:"10px 13px",width:"40px",position:"absolute",height:"36px",right:"2px",top:"2px","text-align":"center",transition:"transform .2s ease"},type:"gray",onClick:t},{default:r(()=>[a(h,{style:{width:"14px",height:"14px",color:"black"}})]),_:2},1032,["onClick"])]),option:r(({option:t,search:u})=>[n("div",P,[n("div",{class:"option-title",innerHTML:i.getOptionTitle(t.label,u)},null,8,j),n("div",w,[n("span",null,o(l.strings.id)+": #"+o(t.value),1),n("span",null,o(l.strings.type)+": "+o(t.type),1)])]),n("a",{class:"option-permalink",href:t.link,target:"_blank",onClick:m(()=>{},["stop"])},[a(g)],8,E)]),tag:r(({option:t,remove:u})=>[n("div",R,[n("div",A,o(t.label)+" - #"+o(t.value),1),n("div",{class:"multiselect__tag-remove",onClick:m(f=>u(t),["stop"])},[a(y,{onClick:m(f=>u(t),["stop"])},null,8,["onClick"])],8,D)])]),_:1},8,["options","ajax-search","customLabel","modelValue","placeholder"]),a(d,{type:"gray",size:"medium",onClick:s[1]||(s[1]=t=>i.optionName=[])},{default:r(()=>[_(o(l.strings.clear),1)]),_:1})])}const et=S(L,[["render",J]]);export{et as C};
