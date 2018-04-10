var slimScroll=function(e,t){var n={},i=this,o="wrapper",r="scrollBar",s="scrollBarContainer",l="data-slimscroll",a="offsetTop",c="scrollTop",u="parentElement",d="innerHTML",p="%",v="parentNode",f="srcElement",m=function(e){if(i.initInProcess||(i.initDone||i.init(),Y(n[o]))){n[o].setAttribute("style","overflow: hidden !important");var t=n.E;n.h=n[s].offsetHeight,n.sH=n[o].scrollHeight,n.sP=n.h/n.sH*100,n.sbh=n.sP*n.h/100,t.sH?n.sP1=t.sH/n.h*100:n.sP1=n.sbh<t.mH?t.mH/n.h*100:n.sP,n.rP1=100-n.sP1,n.x=(n.sH-n.h)*((n.sP1-n.sP)/(100-n.sP)),n.sH1=Math.abs(n.x/n.rP1+n.sH/100),n[r].style.height=n.sP1+p,n.reposition=P(n[r],n.h)}else I()},h=function(e,t,n){e.setAttribute(t,n)},g=function(e,t){t.length&&(e.className=t)},S=function(e,t,n){var i=document.createElement("div");return g(i,e),i[d]=t,n.appendChild(i),i},H=function(e){var t=(e=e||event).target||event[f],i=t[u]||t[v],l=n.E;if(n&&i!==n[s]){var a=((e.pageY||event.clientY)-B(n[o][u]||n[o][v]))/n.h*100-n.sP1/2;a>n.rP1?a=n.rP1:a<0&&(a=0),n[r].style.top=a+p,n[o][c]=a*n.sH1,g(n[s],l.S+l.a)}},x=function(e){var t=window.getSelection?window.getSelection():document.selection;t&&(t.removeAllRanges?t.removeAllRanges():t.empty&&t.empty());(e=e||event).currentTarget||e[f];return C("mousemove",document,y),C("mouseup",document,w),n[a]=B(n[o]),n.firstY=e.pageY||event.clientY,n.reposition||(n.reposition=P(n[r],n.h)),!1},P=function(e,t){var n=parseInt(e.style.top.replace(p,""),10)*t/100;return n||0},y=function(e){e=e||event;var t=n.E,i=e.pageY||e.clientY,l=(n.reposition+i-n.firstY)/n.h*100;n.rP1<l&&(l=n.rP1),n.previousTop||(n.previousTop=l+1);var u=l>=0&&n.firstY>n[a];(n.previousTop>l&&u||u&&n[o][c]+n.h!==n.sH)&&(n[r].style.top=l+p,n.previousTop=l,n[o][c]=l*n.sH1),g(n[s],t.S)},w=function(e){e=e||event;var t=n.E;T("mousemove",document),T("mouseup",document),n.reposition=0,g(n[s],t.S+t.a)},b=function(e){e=e||event;if(n){var t=n.E;g(n[s],t.S),n[r].style.top=n[o][c]/n.sH1+p,g(n[s],t.S+t.a)}},C=function(e,t,n){t["on"+e]=n},T=function(e,t){t["on"+e]=null},E=function(e,t,n,i){e.insertRule?e.insertRule(t+"{"+n+"}",i):e.addRule&&e.addRule(t,n,i)},B=function(e){var t=document.documentElement[c];return e.getBoundingClientRect().top+(t||document.body[c])},I=function(){if(e.removeAttribute(l),i.isSlimScrollInserted){var t=e.firstChild.innerHTML;t&&(e.innerHTML=t)}i.isSlimScrollInserted=!1,i.initDone=!1},Y=function(t){return t||(t=e),t.offsetHeight<t.scrollHeight},A=function(){if(I(),Y()){i.initDone=!0,i.initInProcess=!0,h(e,l,"1"),function(){if(!window.slimScrollStylesApplied){if(i.isSlimScrollInserted)return void(i.initInProcess=!1);var e="["+l+"]",t=" !important",n="position:absolute"+t,o=n+";overflow:auto"+t+";left:0px;top:0px"+t+";right:0px;bottom:0px"+t+";padding-right:8px"+t+";",r=n+";top:0px"+t+";bottom:0px"+t+";right:0px;left:auto;width:5px;cursor:pointer"+t+";padding-right:0px"+t+";",s=n+";background-color:#999;top:0px;left:0px;right:0px;",a=document.createElement("style");try{a.appendChild(document.createTextNode(""))}catch(e){}var c=document.head||document.getElementsByTagName("head")[0];c.insertBefore(a,c.hasChildNodes()?c.childNodes[0]:null);var u=a.sheet;u?(E(u,e+">div",o,0),E(u,e+">div+div",r,0),E(u,"[data-scrollbar]",s,0)):a.styleSheet.cssText=e+">div{"+o+"}"+e+">div+div{"+r+"}"+e+">div+div>div{"+s+"}",i.isSlimScrollInserted=!0,window.slimScrollStylesApplied=!0}}();var a=e[d],c=n.E={};t=t||{},c.w=t.wrapperClass||"",c.s=t.scrollBarClass||"",c.S=t.scrollBarContainerClass||"",c.a=t.scrollBarContainerSpecialClass?" "+t.scrollBarContainerSpecialClass:"",c.mH=t.scrollBarMinHeight||25,c.sH=t.scrollBarFixedHeight,e[d]="",n[o]=S(c.w,a,e),n[s]=S(c.S+c.a,"",e),n[r]=S(c.s,"",n[s]),h(n[r],"data-scrollbar","1"),m(),R(),t.keepFocus&&(h(n[o],"tabindex","-1"),n[o].focus()),C("mousedown",n[r],x),C("click",n[s],H),C("scroll",n[o],b),i.initInProcess=!1}else I()},R=function(){n[o].style.overflow="";var e=n[o].offsetWidth-n[o].clientWidth;n[o].style.right=-e+"px",i.isSlimScrollInserted=!0,t.keepFocus&&(h(n[o],"tabindex","-1"),n[o].focus())};return i.resetValues=function(){Object.keys(n).length?(m(),R()):m()},i.init=A,A(),i};