
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="mypostcardIcon.png">

    <title>MyPostCard</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/welcome.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
  </head>

  <script src="/js/app.js"></script>

  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
      <div>
        <img src="mypostcardIcon.png" class="iconNavBar"></img>
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">MyPostCard</a>
      </div>
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="#">Sign out</a>
        </li>
      </ul>
    </nav>


    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="home"></span>
                  Home
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file"></span>
                  Orders
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="#">
                  <span data-feather="shopping-cart"></span>
                  Products
                </a>
              </li>
          </ui>
          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          <h2>Items List</h2>
          <div  id="app">
            <table id="tableItems" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>id</th>
                  <th class="thOptions">Thumbnail</th>
                  <th class="thOptions">Title</th>
                  <th class="thOptions">Price Options</th>
                  <th>Price</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @php $counter=1; @endphp
                   @foreach($response as $item)
                    <tr class="@if($counter==4) is-active @endif">
                        <td> {{$item->id}} </td>
                        <td>
                          <img class="thumbnail" src="{{$item->thumb_url}}" alt="{{$item->title}}">
                        </td>
                        <td> {{$item->title}} </td>
                        <td>
                          <select class="form-control" id="exampleFormControlSelect1" v-on:change="changeItem({{$item->id}}, $event)">
                            <option value='XXL' >XXL</option>
                            <option value='XL'>XL</option>
                            <option value='Envelope'>Envelope</option>
                            <option value='Premium'>Premium</option>
                          </select>
                        </td>
                        <td> <p id='p{{$item->id}}'></p> </td>
                        <td>
                          <form method="POST" action="{{ route('makePDF') }}">
                            <input type="hidden" name="title" value="{{ $item->title }}">
                            <input type="hidden" name="thumbnail" value="{{ $item->thumb_url }}">
                            {!! csrf_field() !!}
                            <button type="submit" class="btn">
                                <span data-feather="download"></span>
                            </button>
                        </form>
                        </td>
                    </tr>
                    @php if($counter==4) $counter=0;
                    $counter++;
                    @endphp
                   @endforeach
              </tbody>
            </table>
          </div>
        </main>
      </div>
    </div>

    <!-- JavaScript Libraries
    ================================================== -->

     <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
     <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
     <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<!-- Datatable-->
     <script>
     $(document).ready(function() {
       $('#tableItems').dataTable( {
           "order": []
           ,searching: false
           , columnDefs: [{
              targets: "_all",
              orderable: false
          }]
          ,"lengthMenu": [20]
         } );

     } );
     </script>
<!-- Get Prices-->
    <script>

    </script>
    <script>
    const app = new Vue({
        el: '#app',
        data: {
        selected: "selected"
        },
        methods: {
          changeItem: function changeItem(rowId, event) {
            $.ajax({
              url: 'https://www.mypostcard.com/mobile/product_prices.php?json=1&type=get_postcard_products&currencyiso=EUR&store_id='+rowId,

              crossDomain: true,
              type:"GET",
              contentType: "application/json; charset=utf-8",
              async:false,
                  success: function (result) {
                      console.log(result);
                      this.selected = parseFloat(result['products']['0']['product_options'][event.target.value]['price'])
                      +parseFloat(result['products']['0']['price']) ;
                      document.getElementById('p'+rowId).innerHTML = "€ "+this.selected ;
                  },
                  error: function () {
                      console.log("error");
                  }
            });

          }
        }
    });
    </script>
<!-- Icons-->
    <script>
      feather.replace()
    </script>

  </body>
</html>
