<!-- 
This is a backup file for the form used to enroll in a course. 
It replaces the "eventDetailpage" template. 
-->


<table class="contentpaneopen" style="border: 0px;">
<tbody>
<tr class="headingrow">
<td class="contentheading" width="100%">{{Title:TITLE}}</td>
<td class="buttonheading" align="right" width="20">{{Ical Button:ICALBUTTON}}</td>
<td class="buttonheading" align="right" width="20">{{Edit Button:EDITBUTTON}}</td>
</tr>
<tr>
<td colspan="4" align="left" valign="top">
<table style="border: 0px; width: 100%;">
<tbody>
<tr>
<td>{{Repeat Summary:REPEATSUMMARY}} {{Previous/Next Links:PREVIOUSNEXT}}</td>
<td class="ev_detail contact">{{Creator:CREATOR}}</td>
<td class="ev_detail hits">{{Hits:HITS}}</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr align="left" valign="top">
<td colspan="4">{{Description:DESCRIPTION}}</td>
</tr>
<tr>
<td class="ev_detail" colspan="4" align="left" valign="top"><strong>{{Location Label:LOCATION_LABEL}}</strong>{{Location:LOCATION}}</td>
</tr>
<tr>
<td class="ev_detail" colspan="4" align="left" valign="top"><strong>{{Contact Label:CONTACT_LABEL}}</strong>{{Contact:CONTACT}}</td>
</tr>
<tr>
<td class="ev_detail" colspan="4" align="left" valign="top">{{Extra Info:EXTRAINFO}}</td>
</tr>
</tbody>
</table>
<!-- Coperio addition --><hr />
<h2>Påmelding</h2>
<form class="enrollment" action="enrollment.php" method="post"><input type="hidden" name="kurs" value="{{Title:TITLE}}" />
<div class="formcontent">
<ul>
<li><span>Navn:</span></li>
<li><input onclick="javascript:this.form.name.focus();this.form.name.select();" type="text" name="name" value="Navn" /></li>
</ul>
</div>
<div class="formcontent">
<ul>
<li><span>Bedrift:</span></li>
<li><input onclick="javascript:this.form.corp.focus();this.form.corp.select();" type="text" name="corp" value="Bedriftens navn" /></li>
</ul>
</div>
<div class="formcontent">
<ul>
<li><span>Tidspunkt:</span></li>
<li><input onclick="javascript:this.form.time.focus();this.form.time.select();" type="datetime" name="time" value="{{Repeat Summary:REPEATSUMMARY}} {{Previous/Next Links:PREVIOUSNEXT}}" readonly="readonly" /></li>
</ul>
</div>
<div class="formcontent">
<ul>
<li><span>Telefon:</span></li>
<li><input onclick="javascript:this.form.phone.focus();this.form.phone.select();" type="number" name="phone" value="00000000" /></li>
</ul>
</div>
<div class="formcontent">
<ul>
<li><span>E-post:</span></li>
<li><input onclick="javascript:this.form.email.focus();this.form.email.select();" type="email" name="email" value="navn@bedrift.no" /></li>
</ul>
</div>
<div class="formcontent">
<ul>
<li><span>Antall personer:</span></li>
<li><input onclick="javascript:this.form.pers.focus();this.form.pers.select();" type="number" name="pers" value="0" /></li>
</ul>
</div>
<div class="formcontent">
<ul>
<li><label>Kommentarer:</label></li>
<li><textarea id="message" onclick="javascript:this.form.message.focus();this.form.message.select();" name="message" rows="5" cols="40">Kommentarer til oss og spesielle ting vi skal ta hensyn til.</textarea></li>
</ul>
</div>
<div class="formcontent">
<ul>
<li><input type="submit" value="Meld deg på!" /></li>
</ul>
</div>
</form><hr /><!-- END Coperio addition -->
<p> </p>
