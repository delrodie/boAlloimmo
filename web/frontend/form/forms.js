		(function ($) {

			"use strict";

			var $document = $(document),
			    $window = $(window),
			    forms = {
				contactForm: $('#contactForm'),
				questionForm: $('#questionForm')
			};

			$document.ready(function () {

				// contact page form
				if (forms.contactForm.length) {
					var $contactform = forms.contactForm;
					$contactform.validate({
						rules: {
							name: {
								required: true,
								minlength: 2
							},
							message: {
								required: true,
								minlength: 20
							},
							email: {
								required: true,
								email: true
							}

						},
						messages: {
							name: {
								required: "Please enter your name",
								minlength: "Your name must consist of at least 2 characters"
							},
							message: {
								required: "Please enter message",
								minlength: "Your message must consist of at least 20 characters"
							},
							email: {
								required: "Please enter your email"
							}
						},
						submitHandler: function submitHandler(form) {
							$(form).ajaxSubmit({
								type: "POST",
								data: $(form).serialize(),
								url: "form/process-contact.php",
								success: function success() {
									$('.successform', $contactform).fadeIn();
									$orderForm.get(0).reset();
								},
								error: function error() {
									$('.errorform', $contactform).fadeIn();
								}
							});
						}
					});
				}

				// question page form
				if (forms.questionForm.length) {
					var $questionForm = forms.questionForm;
					$questionForm.validate({
						rules: {
							name: {
								required: true,
								minlength: 2
							},
							message: {
								required: true,
								minlength: 20
							},
							email: {
								required: true,
								email: true
							}

						},
						messages: {
							name: {
								required: "Please enter your name",
								minlength: "Your name must consist of at least 2 characters"
							},
							message: {
								required: "Please enter message",
								minlength: "Your message must consist of at least 20 characters"
							},
							email: {
								required: "Please enter your email"
							}
						},
						submitHandler: function submitHandler(form) {
							$(form).ajaxSubmit({
								type: "POST",
								data: $(form).serialize(),
								url: "form/process-question.php",
								success: function success() {
									$('.successform', $questionForm).fadeIn();
									$questionForm.get(0).reset();
								},
								error: function error() {
									$('.errorform', $questionForm).fadeIn();
								}
							});
						}
					});
				}
			});
		})(jQuery);