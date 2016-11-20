<div class="box" id="target">
    <div id="target_title" style="background-color:#00BFFF; padding:5px; text-align:center; font-size: 18px; margin-bottom:5px;">Target</div>
    <div class="content">
        <table class="table_box">
            <colgroup span="1" style="width:180px;"></colgroup>
            <colgroup span="1" style="width:240px;"></colgroup>
            <tbody>
                <tr>
                    <td align="center">Target DataSource id</td>
                    <td align="center">
                        <input type="text" name="target_id"></td>
                </tr>
                <tr>
                    <td align="center">Target DataSource Type</td>
                    <td align="center">
                        <select id="tds_type" name="tds_type" onchange="changeTarget()">
                            <option value="sparqlEndpoint">SPARQL</option>
                            <option value="file">file</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table> 

        <div id="target_selection">
            <table class="table_box">
                <colgroup span="1" style="width:180px;"></colgroup>
                <colgroup span="1" style="width:240px;"></colgroup>
                <tbody>
                    <tr>
                        <td align="center">file path</td>
                        <td align="center">
                            <input type="text" name="target_var1"></td>
                    </tr>
                    <tr>
                        <td align="center">format</td>
                        <td align="center">
                            <select name="target_var2">
                                <option value="RDF/XML">RDF/XML</option>
                                <option value="N-TRIPLE">N-TRIPLE</option>
                                <option value="TURTLE">TURTLE</option>
                                <option value="TTL">TTL</option>
                                <option value="N3">N3</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <table class="table_box">
            <colgroup span="1" style="width:180px;"></colgroup>
            <colgroup span="1" style="width:240px;"></colgroup>
            <tbody>
                <tr>
                    <td align="center">Target var</td>
                    <td align="center">
                        <input type="text" name="target_var">
                    </td>
                </tr>
                <tr>
                    <td align="center">Target Restriction</td>
                    <td align="center">
                        <input type="text" name="target_restriction">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>