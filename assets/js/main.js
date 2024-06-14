(function($) {

	"use strict";


})(jQuery);

const form = document.getElementById('myForm');

form.addEventListener('submit', (event) => {
  event.preventDefault();

  // Perform login or signup logic here

  // Prevent user from going back to the previous page
  window.history.replaceState(null, null, location.href);
});	