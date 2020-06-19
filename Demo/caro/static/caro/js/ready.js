var btn = {
  changeState: function(){
   var button = document.getElementById(“readyButton”);
   button.style.display = ‘none’; // insert this line
 },
 changeStatusA: function(){
   var message = document.getElementById(“messageA”);
   message.innerHTML = ‘Ready’;
 },
 changeStatusB: function(){
   var message = document.getElementById(“messageB”);
   message.innerHTML = ‘Ready’;
 },
}
