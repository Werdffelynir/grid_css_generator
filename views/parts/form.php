<form id="form-generator" action="" name="">
<table class="form_table" style="width: 100%; border: none;">
    <tr>
        <td style="width: 33.3333333%">&nbsp;</td>
        <td style="width: 33.3333333%">&nbsp;</td>
        <td style="width: 33.3333333%">&nbsp;</td>
    </tr>
    <tr>
        <td>
            <select name="prefix">
                <option value=".G" selected>G</option>
                <option value=".grid-" >grid-</option>
            </select>
        </td>
        <td>Prefix css property</td>
        <td></td>
    </tr>
    <tr>
        <td>
            <div id="width-slider"></div>
        </td>
        <td>Abstract Width</td>
        <td><input type="text" id="width-amount" readonly></td>
    </tr>
    <tr>
        <td>
            <div id="padding-slider"></div>
        </td>
        <td>Padding between columns</td>
        <td><input type="text" id="padding-amount" readonly></td>
    </tr>
    <tr>
        <td>
            <div id="grid-slider"></div>
        </td>
        <td>Grid columns</td>
        <td><input type="text" id="grid-amount" readonly></td>
    </tr>
</table>
    <input value="Generate" type="submit"/>
</form>