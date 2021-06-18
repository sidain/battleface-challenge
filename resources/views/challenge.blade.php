<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">


</head>
<body>


    <div id="app">
        <div class="container">
            <div class="card bg-light border p-5 mb-5 mt-5">
                <h1>Login::  <span v-if="login.loggedIn == true" class="bg-success p-1 text-white border border-dark rounded">Logged IN</span></h1>
                <form id="login" v-on:submit.prevent="processLogin">

                    <div class="row form-group">
                        <label class="col-2 col-form-label" for="">Email:</label>

                        <div class="col-10">
                            <input v-model='login.email' class="form-control-plaintext" type="text" name="email" id="email" readonly>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-2 col-form-label" for="">Password:</label>

                        <div class="col-10">
                            <input v-model='login.password' class="form-control-plaintext" type="text" name="password" id="password" readonly>
                        </div>
                    </div>


                    <div class="row mt-5 justify-content-end">
                        <div class="col-auto">
                            <button class="btn btn-primary" type="submit">Login</button>
                        </div>
                    </div>

                </form>
            </div>

            <div class="card bg-light border p-5 mb-5">
                <h1>Get a Quote::</h1>
                <form id="quote" action="/quotation" v-on:submit.prevent="processQuote">

                    <div class="row form-group mb-1">
                        <label class="col-2 col-form-label"  for="">Ages, comma seperated</label>

                        <div class="col-10">
                            <input v-model='quote.age_list' id="age_list" name="age_list" class="form-control age_list" type="text">
                        </div>
                    </div>

                    <div class="row mb-5 mt-5 form-group border p-5">
                        <div class="col">
                            <label class="" for="">Start date</label>

                            <div class="">
                                <input  v-model='quote.start_date' id="start_date" name="start_date"  class="form-control start_date" type="date">
                            </div>
                        </div>


                        <div class="col">
                            <label class="" for="">End date</label>

                            <div class="">
                                <input  v-model='quote.end_date' id="end_date" name="end_date" class="form-control end_date" type="date">
                            </div>
                        </div>
                    </div>



                    <div class="row  form-group mb-1">
                        <label class="col-2 col-form-label" for="">Currency</label>

                        <div class="col-10">
                            <select v-model='quote.currency_id' id="currency_id" name="currency_id"  class="form-select currency_id">
                                <option value=""></option>

                                <option class=""  v-for="(item, index) in currencies" :key="index"  :value="item.currency_id">
                                    @{{item.currency_id}} :: @{{item.name}}
                                </option>
                            </select>


                        </div>
                    </div>


                    <div class="row mt-5 justify-content-end">
                        <div class="col-auto">
                            <button class="btn btn-primary" type="reset">Reset</button>
                        </div>

                        <div class="col-auto">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>

                    </div>
                </form>
            </div>

            <div class="card bg-light border p-5 mb-5" >
                <h1>Your Quote::</h1>

                <?php
                ?>

                <table>
                    <tr>
                        <th>Quote ID</th>
                        <th>Currency</th>
                        <th>Total</th>
                    </tr>

                    <tr>
                        <td>@{{result.id}}</td>
                        <td>@{{result.currency_id}}</td>
                        <td>@{{result.total}}</td>
                    </tr>
                </table>

            </div>



        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>


    <script>
        // const axios = require('axios').default;
        // Vue.use(axios);

        var app = new Vue({
          el: '#app',
          data: {
            currencies : @json( \App\Models\Currency::select('name', 'currency_id')->get()  ),

            login:{
                email: 'user@email.com',
                password: 'password',
                token:'',
                loggedIn: 'false',
            },

            quote:{

                age_list:'',
                // age_list:'18,36,54',

                start_date:'',
                // start_date:'2020-10-01',

                end_date:'',
                // end_date:'2020-10-30',

                currency_id:'',
                // currency_id:'EUR',
            },

            result:{
                id:"",
                currency:"",
                total:"",
            }
          },
          methods:{
            processLogin: function(){

                axios.post('/api/auth/login', {
                    email:  this.login.email,
                    password: this.login.password,

                    headers:{
                        'Content-Type':'application/json',
                        'Accept': 'application/json',
                    }
                }).then( response => {
                    this.login.token=response.data.access_token;

                    if(this.login.token.length > 100 ){
                        this.login.loggedIn = true;
                    }

                    console.log(response);
                }).catch( error => {
                    console.log(error);
                });

            },

            processQuote: function(){
                var isError  = false;
                var msg = "Please Fill out the form";
                var eleObject = null;

                if( this.quote.age_list.length <= 0){
                    isError = true;
                    msg = "All values in ages must be numbers, between the values of 18 and 70";
                    eleObject = document.getElementById('age_list');
                }
                else{
                    ages = this.quote.age_list.trim().split(',');

                    for(e=0; e<ages.length; e++)
                    {
                        var ele = ages[e];

                        if( !( Number.isInteger( parseInt(ele) ) && ( ele >= 18 ) && ( ele <= 70 ) ) ){
                            isError = true;
                            msg = "All values in ages must be numbers, between the values of 18 and 70";
                            eleObject = document.getElementById('age_list');
                            return false;
                        }
                    }

                }

                if( this.quote.start_date.length <= 0){
                    isError = true;
                    msg = "Please select a start date";
                    eleObject = document.getElementById('start_date');
                }

                if( this.quote.end_date.length <= 0){
                    isError = true;
                    msg = "Please select an end date";
                    eleObject = document.getElementById('end_date');
                }

                var d1 = new Date(document.getElementById('start_date').value);
                var d2 = new Date(document.getElementById('end_date').value);

                date_dif = d2-d1;

                if( date_dif < 0 ){
                    isError = true;
                    msg = "Start date must come before end date";
                    eleObject = document.getElementById('start_date');
                }


                if( this.quote.currency_id.length <= 0){
                    isError = true;
                    msg = "Please select a currency";
                    eleObject = document.getElementById('currency_id');
                }

                if( !isError ){
                    axios.post('/quotation',
                        {
                            'age_list': this.quote.age_list,
                            'start_date': this.quote.start_date,
                            'end_date': this.quote.end_date,
                            'currency_id': this.quote.currency_id,
                        },
                        {
                            headers: {
                                'Authorization': `Bearer ${app._data.login.token}`,
                                'Content-Type':'application/json',
                                'Accept': 'application/json',
                            }
                        }
                    ).then( response => {
                        this.result.id = response.data.quotation_id;
                        this.result.currency_id = response.data.currency_id;
                        this.result.total = response.data.total;
                    }).catch( error => {
                        if( error.response.status === 401 ){
                            alert(error.response.data.message+" Please Login.");
                        }
                        else{
                            alert(error.response.data.message);
                        }

                        console.log(error.response);
                    });
                }
                else {
                    alert(msg);
                    eleObject.focus();
                }

            }

          },
        })
    </script>

</body>
</html>
