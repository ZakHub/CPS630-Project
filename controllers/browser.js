window.onload=function () {
        function myBrowser(){
            var userAgent = navigator.userAgent;
            if (userAgent.indexOf("Opera") > -1) {
                return "Opera Browser"
            }else if (userAgent.indexOf("Firefox") > -1) {
                return "Firefox Browser";
            }else if (userAgent.indexOf("Chrome") > -1){
                return "Chrome Browser";
            }else if (userAgent.indexOf("Safari") > -1) {
                return "Safari Browser";
            }else {
                return "Unknown Browser"
            }
        }
        document.getElementById("brower").innerHTML= myBrowser();
    }
