<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Restablecer contraseña</title>
  <style>
    /* Para mejorar la visualización en clientes de correo */
    body {
      font-family: Verdana, Geneva, Tahoma, sans-serif;
      background-color: #ffffff;
      color: #222222;
      margin: 0;
      padding: 20px;
    }
    a {
      color: #1a73e8;
      word-break: break-word;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
    table {
      max-width: 600px;
      margin: auto;
      border: 1px solid #e0e0e0;
      padding: 20px;
      border-collapse: collapse;
    }
    hr {
      border: none;
      border-top: 1px solid #e0e0e0;
      margin: 30px 0;
    }
    .footer-text {
      font-size: 12px;
      color: #999;
      text-align: center;
    }
    .validity {
      font-size: 12px;
      color: #666;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <table role="presentation" cellpadding="0" cellspacing="0">
    <tr>
      <td>
        <h1 style="font-size: 22px; font-weight: normal; margin-bottom: 24px; color: #0a3d62;">Restablecer contraseña</h1>
        <p>Hola,</p>
        <p>Recibiste este correo porque solicitaste restablecer tu contraseña.</p>
        <p>Para continuar, haz clic en el enlace siguiente o cópialo y pégalo en tu navegador:</p>
        <p><a href="{{ $resetUrl }}">{{ $resetUrl }}</a></p>
        <p>Si no solicitaste este cambio, puedes ignorar este correo con seguridad.</p>
        <p class="validity">Este enlace es válido por 60 minutos.</p>
        <hr />
        <p class="footer-text">&copy; {{ date('Y') }} Capachica Ruraq. Todos los derechos reservados.</p>
      </td>
    </tr>
  </table>
</body>
</html>
