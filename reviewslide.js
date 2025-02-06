const review_text = document.getElementsByClassName('reviewdiv')
const arrow = document.getElementById('arrow')

arrow.addEventListener('click', function() {
    if (review_text.classList.contains('hidden')) {
      review_text.classList.remove('hidden'); 
    }
  });