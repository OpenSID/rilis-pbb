import{l as n,$ as e,b as i,p as l,S as s,a}from"./vendor-57f4d5a4.js";window.isEmpty=n.isEmpty;window.$=e;window.jQuery=e;window.bootstrap=i;window.popper=l;window.Swal=s;window.axios=a;window.axios.defaults.headers.common["X-Requested-With"]="XMLHttpRequest";document.addEventListener("DOMContentLoaded",()=>{e(document).on("select2:open",()=>{let t=document.querySelectorAll(".select2-container--open .select2-search__field");t[t.length-1].focus()}),[].slice.call(document.querySelectorAll("select.cs-select")).forEach(function(t){new SelectFx(t)}),e(".selectpicker").selectpicker,e(".search-trigger").on("click",function(t){t.preventDefault(),t.stopPropagation(),e(".search-trigger").parent(".header-left").addClass("open")}),e(".search-close").on("click",function(t){t.preventDefault(),t.stopPropagation(),e(".search-trigger").parent(".header-left").removeClass("open")}),e(".count").each(function(){e(this).prop("Counter",0).animate({Counter:e(this).text()},{duration:3e3,easing:"swing",step:function(t){e(this).text(Math.ceil(t))}})}),e("#menuToggle").on("click",function(t){var o=e(window).width();o<1010?(e("body").removeClass("open"),o<760?e("#left-panel").slideToggle():e("#left-panel").toggleClass("open-menu")):(e("body").toggleClass("open"),e("#left-panel").removeClass("open-menu"))}),e(".menu-item-has-children.dropdown").each(function(){e(this).on("click",function(){var t=e(this).children(".dropdown-toggle").html();e(this).children(".sub-menu").prepend('<li class="subtitle">'+t+"</li>")})}),e(window).on("load resize",function(t){var o=e(window).width();o<1010?e("body").addClass("small-device"):e("body").removeClass("small-device")}),e(".btn-select-file").on("click",function(t){t.preventDefault(),e(this).next().click()})});
