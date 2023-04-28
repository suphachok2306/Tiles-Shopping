/*var product = [{
    id: 1,
    //img: ".\images\brick-wall.jpg",
    img: 'https://cdn.pixabay.com/photo/2016/05/04/13/11/brick-wall-1371349__340.jpg',
    name: "Brick",
    price: 750,
    description: "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates obcaecati eaque soluta? Molestiae, corporis officiis?",
    type: "wall"
}, {
    id: 2,
    //img: ".\images\mosaic.jpg",
    img: "https://cdn.pixabay.com/photo/2015/05/09/12/34/mosaic-759625__340.jpg",
    name: "Mosaic",
    price: 900,
    description: "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates obcaecati eaque soluta? Molestiae, corporis officiis?",
    type: "floor"

}, {
    id: 3,
    //img: ".\images\medieval.jpg",
    img: "https://cdn.pixabay.com/photo/2017/06/28/05/18/medieval-2449784_960_720.jpg",
    name: "Medieval",
    price: 1500,
    description: "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates obcaecati eaque soluta? Molestiae, corporis officiis?",
    type: "floor"
}];*/

var product;


$(document).ready(() => {
    /*if (window.confirm("Do you really want to leave?")) {
        window.open("index.html", "Thanks for Visiting!");
      }*/

    $.ajax({
        method: 'get',
        url: './api/getAllProduct.php',
        /*data: {
            token: localStorage.token
        },*/
        success: function(response) {
            console.log(response)
            if(response.RespCode == 200){

                product = response.Result
                var html = "";
                for (let i = 0; i < product.length; i++) {
                    html += `<div onclick="openProductDetail(${i})" class="product-items ${product[i].type}">
                        <img class="product-img" src="./images/${product[i].img}" alt="">
                        <p style="font-size: 1.2vw;">${product[i].name}</p>
                        <p style="font-size: 0.9vw;">${numberWithCommas(product[i].price)} บาท / กล่อง</p>
                        </div>`;
                    }
                $("#productlist").html(html);
            }
        }, error: function(err) {
            console.log(err)
        }
    })

})




function numberWithCommas(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1,$2");
    return x;
}



function searchBar(elem) {

    var value = $('#'+elem.id).val()
    console.log(value + ": test input")
    console.log(value.toUpperCase() + ": TEST TO UPPER INPUT")


    var html = "";
    for (let i = 0; i < product.length; i++) {
        //if(product[i].name.includes(value)){
        if(product[i].name.includes(value.toUpperCase())){
            html += `<div onclick="openProductDetail(${i})" class="product-items ${product[i].type}">
                    <img class="product-img" src="./images/${product[i].img}" alt="">
                    <p style="font-size: 1.2vw;">${product[i].name}</p>
                    <p style="font-size: 0.9vw;">${numberWithCommas(product[i].price)} บาท / กล่อง</p>
                </div>`;
            }
    }

    if(html == '') {
        $("#productlist").html(`<p>ไม่พบสินค้า</p>`);
    } else{
        $("#productlist").html(html);
    }
}

function searchType(param) {
    $(".product-items").css('display', 'none')
    if(param == 'ทั้งหมด') {
        $(".product-items").css('display', 'block')
    }
    else {
        $("."+param).css('display', 'block')
        console.log(param)
    }
}  

var productIndex = 0;

function openProductDetail(index){
    productIndex = index;
    console.log(productIndex)
    $("#modalDesc").css('display','flex')
    $("#mdd-img").attr('src','./images/' + product[index].img);
    $("#mdd-name").text(product[index].name);
    $("#mdd-price").text(numberWithCommas(product[index].price) + ' บาท / กล่อง');
    $("#mdd-desc").text(product[index].description);
}

function closeModal(){
    $(".modal").css('display','none')
}


var cart = [];

function addToCart(){
    var pass = true; //ไว้เช็คว่าตัวที่มา มีในcart[]ยัง ถ้ามีแล้วจะให้เป็น false
    
    for (let i = 0; i < cart.length; i++) {
        if(productIndex == cart[i].index){
            console.log("Found same product")
            cart[i].count++;
            pass = false;
        }
    }

    if(pass){
        var obj = {
            index: productIndex,
            id: product[productIndex].product_id,
            namePro: product[productIndex].name,
            pricePro: product[productIndex].price,
            imgPro: product[productIndex].img,
            count: 1
        };
        cart.push(obj)
    }
    console.log(cart)

    Swal.fire({
        icon: 'succcess',
        title: 'นำ ' + product[productIndex].name + ' เข้าตะกร้าแล้ว !'
    })

    $("#cartcount").css('display','flex').text(cart.length)
}




function openCart(){
    $("#modalCart").css('display','flex')
    rendercart();
}

function rendercart(){
    if(cart.length > 0){
        console.log(cart.length + ' test');
        var html = '';
        for (let i = 0; i < cart.length; i++) {
            html += `<div class="cartlist-items">
                            <div class="cartlist-left">
                                <img src="./images/${cart[i].imgPro}" alt="">
                                <div class="cartlist-detail">
                                    <p style="font-size: 1.5vw;">${cart[i].namePro}</p>
                                    <p id = "totalPrice${i}" style="font-size: 1.2vw;">${numberWithCommas(cart[i].pricePro * cart[i].count)} บาท / กล่อง</p>
                                </div>
                            </div>
                            <div class="cartlist-right">
                                <p onclick ="decIncItems('decrease', ${i})" class="btnc">-</p>
                                <p id = "countItems${i}" style="margin: 0 15px;">${cart[i].count} </p>
                                <p onclick ="decIncItems('increase', ${i})" class="btnc">+</p>
                            </div>
                        </div>`;
        }

        /*<div class="cartlist-buttom">
        <p id = "totalAmount" style="font-size: 1.2vw;">${numberWithCommas(parseInt(cart[0].pricePro) + parseInt(cart[1].pricePro))} THB</p>
        </div>*/
        $("#mycart").html(html)
    }
    
    else{
        $("#mycart").html(`<p>ไม่พบสินค้า</p>`)
    }
}

function decIncItems(action, index) {
    if(action == 'decrease'){
        if(cart[index].count > 0){
            cart[index].count--;
            $("#countItems"+ index).text(cart[index].count)

            $("#totalPrice"+ index).text(numberWithCommas(cart[index].pricePro * cart[index].count)+ ' บาท / กล่อง')

            console.log(cart[index].pricePro * cart[index].count)
            console.log(cart[index].count)

            if(cart[index].count <= 0){
                Swal.fire({
                    icon: 'warning',
                    title: 'คุณต้องการเอาสินค้าออกจากตะกร้าใช่หรือไม่',
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'ใช่',
                    cancelButtonText: 'ไม่'
                }).then((res) =>{
                    if(res.isConfirmed){
                        cart.splice(index, 1)
                        console.log(cart)
                        rendercart();
                        $("#cartcount").css('display','flex').text(cart.length)

                        if(cart.length <= 0){
                            $("#cartcount").css('display','none')
                        }
                    }
                    else{
                        cart[index].count++;
                        //rendercart();
                        //$("#cartcount").css('display','flex').text(cart.length)
                        $("#countItems"+ index).text(cart[index].count)

                        $("#totalPrice"+ index).text(numberWithCommas(cart[index].pricePro * cart[index].count))

                    }
                })
            }
        }
    }
    else if(action == 'increase'){
        cart[index].count++;
        $("#countItems"+ index).text(cart[index].count)

        $("#totalPrice"+ index).text(numberWithCommas(cart[index].pricePro * cart[index].count) + ' บาท / กล่อง')
    }

}


function buyNow() {
    $.ajax({
        method: 'post',
        url: './api/buyNow.php',
        data: {
            token: localStorage.token,
            product: cart,
        }, success: function(response) {
            console.log(response)
            if(response.RespCode == 200){
                Swal.fire({
                    title: 'คุณต้องการสั่งซื้อใช่ไหม?',
                    icon: 'warning',                   
                    html: `<div class="card"> 
                            <p>ราคา : ${numberWithCommas(response.Amount.Amount)} บาท</p>
                            <p>ค่าส่ง : ${numberWithCommas(response.Amount.Shipping)} บาท</p>
                            <p>ภาษี  : ${numberWithCommas(response.Amount.Vat)} บาท</p>
                            <p>ราคารวมทั้งหมด : ${numberWithCommas(response.Amount.Netamount)} บาท</p>
                        </div>`,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่',
                    cancelButtonText: 'ยกเลิก'
                  }).then((result) => {
                    if (result.isConfirmed) {
                        closeModal();
                        window.location.href = './pay.html'
                    }
                    else{
                        cancelOrder();
                    }
                  })
            }
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'มีบางอย่างผิดพลาด!'
                })
            }
        }, error: function(err) {
            console.log(err)
        }
    })
}


function cancelOrder(){
    $.ajax({
                method: 'post',
                url: './api/pay.php',
                data: {
                    tokenFor: localStorage.token
                }, success: (response) => {
                    console.log('good',response)
                    if(response.RespCode == 200){
                        //localStorage.clear();
                        Swal.fire({
                            icon: 'success',
                            title: "ยกเลิกสินค้าสำเร็จ",
                            timer: 1000
                        }).then(() => {
                            localStorage.setItem('token',(takeToken));
                            localStorage.setItem('firstname',(takeFirstname));
                            localStorage.setItem('lastname',(takeLastname));
                            window.location.href = './index.html'
                        })
                    }
                }, error: (err) => {
                    console.log('bad',err)
                }
            })
}


function openNav() {
    document.getElementById("mySidebar").style.width = "250px";
    //document.getElementById("main").style.marginLeft = "250px";  
    //document.getElementById("main-content").style.marginLeft = "250px";
    //document.getElementById("main").style.display="none";
  }
  
  function closeNav() {
    document.getElementById("mySidebar").style.width = "0";
    //document.getElementById("main").style.marginLeft= "0";  
    //document.getElementById("main").style.display="block";  
  }

  
