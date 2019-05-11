<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  </head>
  <style>
      /* スマホでの表示 */
    #question{
    	width:95%;
      margin:2em auto;
    	border:#6699ff 1.5px solid;
    }

    #question th{
      padding:3px;
    	display:block;
    }

    #question td{
    	padding:5px;
    	display:block;
    }

    @media only screen and (min-width: 780px) {

        /* PCでの表示 */
      #question{
      	width:100%
        margin:5px auto;
      	font-size:90%;
      	border:#6699ff 1.5px solid;
      }

      #question tr{
        border-bottom:#6699ff 1px solid;
      }

      #question tr:last-child{
      	border:none;
       }

      #question th{
      	width:40%;
        padding:5px 10px;
      	display:table-cell;
      	border-right:#6699ff 1px solid;
      }

      #question td{
      	width:60%;
        padding:5px 10px;
      	display:table-cell;
      }
    }

    #partner {
      margin-bottom: 20px;
    }
  </style>
  <body>
    <div class="container text-center mt-2 mb-5">
      <h1 class="text-primary display-3">@yield('title')</h1>
      @yield('body')
    </div>
  </body>
</html>
