// Функция для проверки заполненности полей формы комментария
function checkFields(form) {
    var name = form.find('input[name="name"]').val();
    var comment = form.find('input[name="comment"]').val();
  
    if (name !== '' && comment !== '') {
      return true;
    } else {
      return false;
    }
  }
  
  // Привязка обработчика события "submit" ко всем формам с классом "form_answer"
  $('.form_answer').on('submit', function(event) {
    if (!checkFields($(this))) {
      event.preventDefault();
      alert('Пожалуйста, заполните все поля перед отправкой.');
    }
  });
  