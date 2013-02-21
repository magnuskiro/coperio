/*global window, localStorage, fontSizeTitle, bigger, reset, smaller, biggerTitle, resetTitle, smallerTitle, Cookie */
var prefsLoaded = false;
var defaultFontSize = 75;
var currentFontSize = defaultFontSize;

function supportsLocalStorage() {
return ('localStorage' in window) && window.localStorage !== null;
}

function setFontSize(fontSize) {
document.body.style.fontSize = fontSize + '%';
}

function changeFontSize(sizeDifference) {
currentFontSize = parseInt(currentFontSize, 10) + parseInt(sizeDifference * 5, 10);
if (currentFontSize > 180) {
currentFontSize = 180;
} else if (currentFontSize < 60) {
currentFontSize = 60;
}
setFontSize(currentFontSize);
}

function revertStyles() {
currentFontSize = defaultFontSize;
changeFontSize(0);
}

function writeFontSize(value) {
if (supportsLocalStorage()) {
localStorage.fontSize = value;
} else {
Cookie.write("fontSize", value, {duration: 180});
}
}

function readFontSize() {
if (supportsLocalStorage()) {
return localStorage.fontSize;
} else {
return Cookie.read("fontSize");
}
}

function setUserOptions() {
if (!prefsLoaded) {
var size = readFontSize();
currentFontSize = size ? size : defaultFontSize;
setFontSize(currentFontSize);
prefsLoaded = true;
}
}
/////////////////////////////////////////////////////////////////////////////nd biz code font zie

function setActiveStyleSheet(title) {
createCookie("ColorCSS", title, 365);
//window.location.reload();
window.location.reload();
return;
}

function createCookie(name,value,days) {
if (days) {
var date = new Date();
date.setTime(date.getTime()+(days*24*60*60*1000));
var expires = "; expires="+date.toGMTString();
}
else expires = "";
document.cookie = name+"="+value+expires+"; path=/";
}

function setScreenType(screentype){
createCookie("ScreenType", screentype, 365);
//window.location.reload();
bclass = document.body.className.trim();
if (bclass.indexOf(' ') > 0){
bclass = bclass.replace(/^\w+/,screentype);
}else{
bclass = screentype + ' ' + bclass;
}

document.body.className = bclass;
equalHeightInit();
createCookie("ScreenType", screentype, 365);
}

String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g, ""); };

function changeToolHilite(oldtool, newtool) {
if (oldtool != newtool) {
if (oldtool) {
oldtool.src = oldtool.src.replace(/-hilite/,'');
}
newtool.src = newtool.src.replace(/.gif$/,'-hilite.gif');
}
}

//addEvent - attach a function to an event
function atAddEvent(obj, evType, fn){
if (obj.addEventListener){
obj.addEventListener(evType, fn, false);
return true;
} else if (obj.attachEvent){
var r = obj.attachEvent("on"+evType, fn);
return r;
} else {
return false;
}
}

function equalHeight (elems){
if (!elems) return;
var maxh = 0;
for (var i=0; i<elems.length; i++)
{
if (elems[i] && elems[i].scrollHeight > maxh) maxh = elems[i].scrollHeight;
}

for (i=0; i<elems.length; i++){
if (elems[i]) elems[i].parentNode.style.height = maxh + "px";
}
}

function getElem (id) {
var obj = document.getElementById (id);
if (!obj) return null;
var divs = obj.getElementsByTagName ('div');
if (divs && divs.length >= 1) return divs[divs.length - 1];
return null;
}

function getFirstDiv (id) {
var obj = document.getElementById (id);
if (!obj) return null;
var divs = obj.getElementsByTagName ('div');
if (divs && divs.length >= 1) return divs[0];
return obj;
}

function getElementsByClass(searchClass,node,tag) {
var classElements = new Array();
var j = 0;
if ( node == null )
node = document;
if ( tag == null )
tag = '*';
var els = node.getElementsByTagName(tag);
var elsLen = els.length;
var pattern = new RegExp('(^|\\s)'+searchClass+'(\\s|$)');
for (var i = 0; i < elsLen; i++) {
if ( pattern.test(els[i].className) ) {
classElements[j] = els[i];
j++;
}
}
//alert(searchClass + j);
return classElements;
}

function instr(str, item){
var arr = str.split(" ");
for (var i = 0; i < arr.length; i++){
if (arr[i] == item) return true;
}
return false;
}

function equalHeightInit (){
var at_spl = document.getElementById('at-bottom');
if (!at_spl) return;
var atblocks = getElementsByClass ("moduletable", at_spl, "DIV");
equalHeight (atblocks);
}

atAddEvent (window, 'load', equalHeightInit);

function fixIE() {
var objs = getElementsByClass ("createdate", null, "TD");
if (objs) {
for (var i=0; i<objs.length; i++){
objs[i].innerHTML = "<span>" + objs[i].innerHTML + "</span>";
}
}
}

/*function setActiveStyleSheet1(url,act,style,old){
url = url + '?act=' + act;
url = url + '&style=' + style;
url = url + '&old=' + old;
var myAjax = new Ajax(url, {method: 'get', onComplete: updateTool}).request();
}

function updateTool(){
window.location.reload();
}
*/atAddEvent (window, 'load', fixIE);
