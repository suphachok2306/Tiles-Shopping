function talk() {
    var know = {
        "what time does the shop open?": "Everyday at 8:00AM - 17.00PM",
        "which province is the shop in?": "Nakhon Phanom:)",
        /*"What can i do for you": "Search CodeWithRandom on Google>>Thank Me Later",
        "Your followers":
            "I have my family of 200000 members, i don't have follower ,have supportive Famiy ",
        ok: "Thank You So Much ",
        Bye: "Okay! Will meet soon..",*/
        "hello" : "Hello, do you have any questions? or you can contact us at 098-6185-361.",
        "hi" : "Hello, do you have any questions? or you can contact us at 098-6185-361.",
        "excuse me" : "Hello, do you have any questions? or you can contact us at 098-6185-361.",

        "open" :"Everyday at 8:00AM - 17.00PM",
        "ร้านเปิดกี่โมง": "ร้านเปิดให้ใช้บริการทุกวัน ตั้งแต่เวลา 8:00 จนถึง 17:00 ครับ",
        "เปิดกี่โมง": "ร้านเปิดให้ใช้บริการทุกวัน ตั้งแต่เวลา 8:00 จนถึง 17:00 ครับ",
        "เปิด": "ร้านเปิดให้ใช้บริการทุกวัน ตั้งแต่เวลา 8:00 จนถึง 17:00 ครับ",

        "close" :"Everyday at 8:00AM - 17.00PM",
        "ร้านปิดกี่โมง": "ร้านเปิดให้ใช้บริการทุกวัน ตั้งแต่เวลา 8:00 จนถึง 17:00 ครับ",
        "ปิดกี่โมง": "ร้านเปิดให้ใช้บริการทุกวัน ตั้งแต่เวลา 8:00 จนถึง 17:00 ครับ",
        "ปิด": "ร้านเปิดให้ใช้บริการทุกวัน ตั้งแต่เวลา 8:00 จนถึง 17:00 ครับ",

        "เปิดวันไหน": "ร้านเปิดให้ใช้บริการทุกวัน ตั้งแต่เวลา 8:00 จนถึง 17:00 ครับ",
        
        "tel" : "098-6185-361",
        "เบอร์โทรศัพท์" : "098-6185-361",
        "เบอร์" : "098-6185-361",



        "สวัสดีครับ" : "สวัสดีครับ/ค่ะ ลูกค้ามีคำถามอะไรเพิ่มเติมไหมครับ หรือสามารถติดต่อได้ที่เบอร์โทร 098-6185-361 ได้เลยครับ",
        "สวัสดีค่ะ" : "สวัสดีครับ/ค่ะ ลูกค้ามีคำถามอะไรเพิ่มเติมไหมครับ หรือสามารถติดต่อได้ที่เบอร์โทร 098-6185-361 ได้เลยครับ",
        "สวัสดี" : "สวัสดีครับ/ค่ะ ลูกค้ามีคำถามอะไรเพิ่มเติมไหมครับ หรือสามารถติดต่อได้ที่เบอร์โทร 098-6185-361 ได้เลยครับ"
    };
    var user = document.getElementById("userBox").value.toLowerCase();
    document.getElementById("chatLog").innerHTML = user + "<br>";

    if (user in know) {
        document.getElementById("chatLog").innerHTML = know[user] + "<br>";
    } else {
        document.getElementById("chatLog").innerHTML =
            "ขออภัย กรุณาลองใช้คำอื่น, ลองใช้คำว่า สวัสดี <br>";
    }
}