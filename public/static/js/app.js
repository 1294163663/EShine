

 function showText(){
      var story = document.getElementById('word');
            var s = document.getElementById('show');
            var i = 0;
            timer=setInterval(function(){
                s.innerHTML=story.innerHTML.substring(0,i);
                i++;
                if(s.innerHTML==story.innerHTML){
                    clearInterval(timer);
                }
            },150);
     }   


window.onload = function() {
    
    
  var mySwiper = new Swiper ('.swiper-container-main', {
   direction : 'vertical',
   pagination: '.swiper-pagination-main',
   mousewheelControl : true,
   onInit: function(swiper){
     swiperAnimateCache(swiper);
     swiperAnimate(swiper);
   },
   onSlideChangeEnd: function(swiper){
    swiperAnimate(swiper);
  }   
})           
  var swiper = new Swiper('.swiper-container-2', {
    pagination: '.swiper-pagination-2',
    effect: 'coverflow',
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: 'auto',
    coverflow: {
      rotate: 50,
      stretch: 0,
      depth: 100,
      modifier: 1,
      slideShadows : true
    }
  });
  setTimeout(showText(),4000); 
}     



