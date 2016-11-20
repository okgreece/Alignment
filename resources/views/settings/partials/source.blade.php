<div class="box" id="source">
    <div id="source_title" style="background-color:#00BFFF; padding:5px; text-align:center; font-size: 18px; margin-bottom:5px;">Source</div>
    <div class="content">
        <table class="table_box">
            <colgroup span="1" style="width:180px;"></colgroup>
            <colgroup span="1" style="width:240px;"></colgroup>
            <tbody>
                <tr>
                    <td align="center">Source DataSource id</td>
                    <td align="center">
                        <input type="text" name="source_id"></td>
                </tr>
                <tr>
                    <td align="center">Source DataSource Type</td>
                    <td align="center">
                        <select id="sds_type" name="sds_type" onchange="changeSource()">
                            <option value="sparqlEndpoint">SPARQL</option>
                            <option value="file">file</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>

        <div id="source_selection">
            <table class="table_box">
                <colgroup span="1" style="width:180px;"></colgroup>
                <colgroup span="1" style="width:240px;"></colgroup>
                <tbody>
                    <tr>
                        <td align="center">file path</td>
                        <td align="center">
                            <input type="text" name="source_var1"></td>
                    </tr>
                    <tr>
                        <td align="center">format</td>
                        <td align="center">
                            <select name="source_var2">
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
                    <td align="center">Source var</td>
                    <td align="center">
                        <input type="text" name="source_var">
                    </td>
                </tr>
                <tr>
                    <td align="center">Source Restriction</td>
                    <td align="center">
                        <input type="text" name="source_restriction">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>