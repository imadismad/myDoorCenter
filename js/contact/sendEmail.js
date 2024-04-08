// Your JavaScript code here
(function(){
    emailjs.init("uesrnwi64Z-2EiQrW");
  })();
  
  function sendEmail(form) {
    emailjs.sendForm('service_zg8e4bw', 'template_z96nppl', form)
      .then(function(response) {
        console.log('SUCCESS!', response.status, response.text);
        alert('Email sent successfully!');
        form.reset(); // Reset the form after successful submission
      }, function(error) {
        console.log('FAILED...', error);
        alert('Failed to send the email. Please try again.');
      });
    return false; // To prevent page reload
  }
  