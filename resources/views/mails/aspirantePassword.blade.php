@component('mail::message')
# Tecnológico Nacional de México en Léon Admisiones 2019

Por este medio nos permitimos informarte que tus datos fueron capturados adecuadamente en el sistema de registro de admisión.

Para completar el registro y poder acceder al sistema, es necesario que actives la cuenta, para ello, debes llevar a cabo los siguientes pasos.

- Visitar el sistema dando clic en el boton: 

- Escribir una contraseña y presionar el botón "Guardar"

@component('mail::button', ['url' => 'http://10.0.31.10/#/response-password-reset?token='.$token.'&CORREO1='.$CORREO1])
Sistema
@endcomponent

Thanks,<br>
ITL
@endcomponent