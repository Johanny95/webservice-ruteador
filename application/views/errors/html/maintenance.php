  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Mantenimento</title>

    <link href='https://fonts.googleapis.com/css?family=Roboto+Mono' rel='stylesheet' type='text/css'>
    <style type="text/css">
    body {
      background-color: black;

      color: white;
      padding: 10px;
      font-family: 'Roboto Mono', sans-serif;
      font-size: 12px;
    }
    p {
      margin: 0;
    }

    p > p {
      display: inline;
    }
    p.command:before {
      content: 'root@server:~$ ';
    }
    table {
      width: 420px; 
    }
    .typed-cursor{
      display: inline-block;
      opacity: 1;
      -webkit-animation: blink 0.7s infinite;
      -moz-animation: blink 0.7s infinite;
      animation: blink 0.7s infinite;
    }
    @keyframes blink{
      0% { opacity:1; }
      50% { opacity:0; }
      100% { opacity:1; }
    }
    @-webkit-keyframes blink{
      0% { opacity:1; }
      50% { opacity:0; }
      100% { opacity:1; }
    }
    @-moz-keyframes blink{
      0% { opacity:1; }
      50% { opacity:0; }
      100% { opacity:1; }
    }
  </style>
</head>
<body>
  <div class="console">
    Welcome to Ubuntu 14.04.3 LTS (GNU/Linux 3.13.0-74-generic x86_64) <br />
    <br />
    * Documentation:  https://help.ubuntu.com/ <br /> <br />

    System information as of Sat Jan 16 13:48:22 CET 2016 <br /><br />

    <table>
      <tr>
        <td>System load:</td>
        <td>0.0</td>
        <td>Processes:</td>
        <td>80</td>
      </tr>
      <tr>
        <td>Usage of /:</td>
        <td>3.1% of 48.11GB</td>
        <td>Users logged in:</td>
        <td>1</td>
      </tr>
      <tr>
        <td>Memory usage: </td>
        <td>17%</td>
        <td>IP address for eth0:</td>
        <td></td>
      </tr>
      <tr>
        <td>Swap usage:</td>
        <td>0%</td>
      </tr>
    </table>

    Graph this data and manage this system at:
    https://landscape.canonical.com/ <br /><br />

    8 packages can be updated. <br />
    0 updates are security updates. <br /> <br />
    root@server:~$ 
    <div class="typed"></div>
  </div>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/1.1.1/typed.min.js" type="text/javascript"></script>
  <script>
      var status = "<p class='command'> sudo systemctl status apache2 </p>"
      + "<p> apache2.service - the apache2 HTTP server </p>"
      + "<p> Loaded: loaded (/lib/systemd/system/apache2.service; enabled; vendor)</p>"
      + "<p> Active: Active (Maintenance) </p>"
      + "<p> Process: 3030 ExecReload=/usr/sbin/apachectl graceful </p>";

      $(".typed").typed({
        strings: ["<p class='command'>mantenimiento</p> <p>-bash: mantenimiento: comando no encontrado</p> "+status+" <p class='command'>bien.. ^1000 el sistema esta en mantenimiento..<span class='typed-cursor'>_</span></p>"],
        typeSpeed: 0,
        loop: false,
        showCursor: false,
        callback: function() {
          // setTimeout( function() {
          //   // $('.console').remove()
          // }, 2000) 
        }
      });
  </script>
</body>
</html>