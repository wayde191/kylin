var mydate=new Date()
var year=mydate.getYear()
if (year < 1000)
year+=1900
var day=mydate.getDay()
var month=mydate.getMonth()
var daym=mydate.getDate()
if (daym<10)
daym="0"+daym
var dayarray=new Array("星期天","星期一","星期二","星期三","星期四","星期五","星期六")
var montharray=new Array("一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月")
document.write("<p>"+dayarray[day]+", "+montharray[month]+" "+daym+", "+year+"</p>")