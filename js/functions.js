var globalVar=0;

$(document).ready(function()
{
	$('.head').slick({
		arrows:false,
		autoplay:true,
		draggable:true,
		centerMode:false,
		slidesToShow:1,
		slidesToScroll:1,
		swipeToSlide:1
		
		/*accessibility: true,
		adaptiveHeight: false,
		arrows: true,
		autoplay: true,
		centerMode: false,
		centerPadding: '50px',
		cssEase: 'ease',
		dots: false,
		draggable: true,
		easing: 'linear',
		fade: false,
		focusOnSelect: false,
		infinite: true,
		initialSlide: 0,
		slide: 'div',
		slidesToShow: 1,
		slidesToScroll: 1,
		speed: 500,
		swipe: true,
		swipeToSlide: false*/
	});
});

function submitSales(str){
	var id=str;
	var first=$("#first_input_"+id).val();
	var last=$("#last_input_"+id).val();
	var prdCode=$("#prdCode"+id).val();
	var lft=document.getElementById("lft"+id);
	if(prdCode!=""){
		var xhr;
		if(window.XMLHttpRequest){
			xhr=new XMLHttpRequest();
		}
		else if(window.ActiveXObject){
			xhr=new ActiveXObject("Microsoft.XMLHTTP");
		}
		if(xhr){
			xhr.onreadystatechange=function(){
				if(xhr.readyState==4&&xhr.status==200){
					var msg=xhr.responseText;
					var msgFirst=msg.substring(0,1);
					var qtyL=msg.substring(1,msg.indexOf("~"));
					var qtyS=msg.substring(msg.indexOf("~")+1,msg.indexOf("*"));
					var sl1=msg.substring(msg.indexOf("*")+1,msg.indexOf("<"));
					var sl2=msg.substring(msg.indexOf("<")+1,msg.indexOf(">"));
					var sl3=msg.substring(msg.indexOf(">")+1,msg.indexOf(")"));
					if(msgFirst==1){
						$("#first_"+id).html(first);
						$("#last_"+id).html(qtyS);
						$("#qtyL"+id).html(qtyL);
						$("#sl2"+id).html(sl1);
						$("#sl3"+id).html(sl3);
						$("#sl2").html(sl2);
						if(qtyL>=10){
							lft.style.background="#55ba55";
						}
						else{
							lft.style.background="#ba3333";
						}
						$(".editbox").hide();
						$(".text").show();
						alert("Product sales successfully posted.");
					}
					else{
						alert(msg);
					}
				}
			}
			xhr.open("GET","submitSales.php?id="+id+"&price="+first+"&qty_sold="+last+"&code="+prdCode,true);
			xhr.send();
		}
	}
	else{
		alert(":::Please enter Product Code");
	}
}

function valSell(){
	if($("#prdCode").val()==""){
		alert(":::Please enter Product Code(s) into the text area to sell.");
	}
}
