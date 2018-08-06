		(function ($) {

			"use strict";

			var $document = $(document),
			    $window = $(window),
			    forms = {
				contactForm: $('#contactForm'),
				profileForm: $('#profileForm'),
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

				//
				if (forms.profileForm.length) {
					var $profileForm = forms.profileForm;
					$profileForm.validate({
						rules: {
							'appbundle_utilisateur[type]': {
								required: true,
							},
							'appbundle_utilisateur[nom]': {
								required: true,
							},
							'appbundle_utilisateur[adresse]': {
								required: true,
							},
							'appbundle_utilisateur[telephone]': {
								required: true,
							},
							'appbundle_utilisateur[description]': {
								required: true,
								minlength: 20
							},
							email: {
								required: true,
								email: true
							}

						},
						messages: {
							'appbundle_utilisateur[type]': {
								required: "Veuillez choisir un statut",
							},
							'appbundle_utilisateur[nom]': {
								required: "Entrez votre nom ou la raison sociale de votre entreprise",
							},
							'appbundle_utilisateur[adresse]': {
								required: "Entrez votre situation geographique",
							},
							'appbundle_utilisateur[telephone]': {
								required: "Entrez votre contact telephonique",
							},
							'appbundle_utilisateur[description]': {
								required: "Veuillez vous presenter aux internautes",
								minlength: "Votre presentation doit composter au moins 20 caractères"
							},
							email: {
								required: "Please enter your email"
							}
						}/*,
						submitHandler: function submitHandler(form) {
							$(form).ajaxSubmit({
								type: "POST",
								data: $(form).serialize(),
								url: "/profile/enregistrement",
								success: function success() {
									$('.successform', $contactform).fadeIn();
									$orderForm.get(0).reset();
								},
								error: function error() {
									$('.errorform', $contactform).fadeIn();
								}
							});
						}*/
					});
				}
			});
		})(jQuery);