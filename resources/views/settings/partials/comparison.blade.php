<div class="box" id="comparison" style="height:auto; border:0px;"><div id="comparison_title" style="background-color:#00BFFF; padding:5px; text-align:center; font-size: 18px; margin-bottom:5px;">Comparison</div><div class="content"><table class="table_box">
            <colgroup span="1" style="width:20px;"></colgroup><colgroup span="1" style="width:150px;"></colgroup><colgroup span="1" style="width:250px;"></colgroup>
            <tbody><tr><th></th><th>Metric</th><th>Threshold</th></tr>
                <tr><td></td><td></td><td></td></tr>
            </tbody></table>
        <table class="table_box">
            <colgroup span="1" style="width:20px;"></colgroup><colgroup span="1" style="width:150px;"></colgroup><colgroup span="1" style="width:250px;"></colgroup>
            <tbody><tr><td><input type="checkbox" id="metric1" name="metric1" value="levenshtein" onchange="showpaths(1)"></td><td>levenshtein</td><td align="center"><input type="number" name="thre1" min="0" max="1" step="0.01" value="0.5"></td></tr>
            </tbody></table>
        <div id="path1" style="margin-left: -10px; display: none; background-color: rgb(245, 245, 245);">
            <table class="table_box">
                <colgroup span="1" style="width:20px;"></colgroup><colgroup span="1" style="width:150px;"></colgroup><colgroup span="1" style="width:250px;"></colgroup>
                <tbody><tr><td></td><td align="center"><i><input type="text" id="path1a" name="path1a" value="" onclick="erasePath( & quot; path1a & quot; )"></i></td><td align="center"><i><input type="text" id="path1b" name="path1b" value="" onclick="erasePath( & quot; path1b & quot; )"></i></td></tr>
                    <tr><td></td><td align="center">
                            <select id="trans1a" name="trans1a"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td><td align="center">
                            <select id="trans1b" name="trans1b"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td></tr>
                    <tr><td></td><td align="center">
                            <select id="trans1c" name="trans1c"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td><td align="center">
                            <select id="trans1d" name="trans1d"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td></tr>
                </tbody></table>
        </div>
        <table class="table_box">
            <colgroup span="1" style="width:20px;"></colgroup><colgroup span="1" style="width:150px;"></colgroup><colgroup span="1" style="width:250px;"></colgroup>
            <tbody><tr><td><input type="checkbox" id="metric2" name="metric2" value="jaro" onchange="showpaths(2)"></td><td>jaro</td><td align="center"><input type="number" name="thre2" min="0" max="1" step="0.01" value="0.5"></td></tr>
            </tbody></table>
        <div id="path2" style="margin-left: -10px; display: none; background-color: rgb(245, 245, 245);">
            <table class="table_box">
                <colgroup span="1" style="width:20px;"></colgroup><colgroup span="1" style="width:150px;"></colgroup><colgroup span="1" style="width:250px;"></colgroup>
                <tbody><tr><td></td><td align="center"><i><input type="text" id="path2a" name="path2a" value="" onclick="erasePath( & quot; path2a & quot; )"></i></td><td align="center"><i><input type="text" id="path2b" name="path2b" value="" onclick="erasePath( & quot; path2b & quot; )"></i></td></tr>
                    <tr><td></td><td align="center">
                            <select id="trans2a" name="trans2a"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td><td align="center">
                            <select id="trans2b" name="trans2b"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td></tr>
                    <tr><td></td><td align="center">
                            <select id="trans2c" name="trans2c"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td><td align="center">
                            <select id="trans2d" name="trans2d"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td></tr>
                </tbody></table>
        </div>
        <table class="table_box">
            <colgroup span="1" style="width:20px;"></colgroup><colgroup span="1" style="width:150px;"></colgroup><colgroup span="1" style="width:250px;"></colgroup>
            <tbody><tr><td><input type="checkbox" id="metric3" name="metric3" value="jaroWinkler" onchange="showpaths(3)"></td><td>jaroWinkler</td><td align="center"><input type="number" name="thre3" min="0" max="1" step="0.01" value="0.5"></td></tr>
            </tbody></table>
        <div id="path3" style="margin-left: -10px; display: none; background-color: rgb(245, 245, 245);">
            <table class="table_box">
                <colgroup span="1" style="width:20px;"></colgroup><colgroup span="1" style="width:150px;"></colgroup><colgroup span="1" style="width:250px;"></colgroup>
                <tbody><tr><td></td><td align="center"><i><input type="text" id="path3a" name="path3a" value="" onclick="erasePath( & quot; path3a & quot; )"></i></td><td align="center"><i><input type="text" id="path3b" name="path3b" value="" onclick="erasePath( & quot; path3b & quot; )"></i></td></tr>
                    <tr><td></td><td align="center">
                            <select id="trans3a" name="trans3a"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td><td align="center">
                            <select id="trans3b" name="trans3b"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td></tr>
                    <tr><td></td><td align="center">
                            <select id="trans3c" name="trans3c"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td><td align="center">
                            <select id="trans3d" name="trans3d"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td></tr>
                </tbody></table>
        </div>
        <table class="table_box">
            <colgroup span="1" style="width:20px;"></colgroup><colgroup span="1" style="width:150px;"></colgroup><colgroup span="1" style="width:250px;"></colgroup>
            <tbody><tr><td><input type="checkbox" id="metric4" name="metric4" value="jaccard" onchange="showpaths(4)"></td><td>jaccard</td><td align="center"><input type="number" name="thre4" min="0" max="1" step="0.01" value="0.5"></td></tr>
            </tbody></table>
        <div id="path4" style="margin-left: -10px; display: none; background-color: rgb(245, 245, 245);">
            <table class="table_box">
                <colgroup span="1" style="width:20px;"></colgroup><colgroup span="1" style="width:150px;"></colgroup><colgroup span="1" style="width:250px;"></colgroup>
                <tbody><tr><td></td><td align="center"><i><input type="text" id="path4a" name="path4a" value="" onclick="erasePath( & quot; path4a & quot; )"></i></td><td align="center"><i><input type="text" id="path4b" name="path4b" value="" onclick="erasePath( & quot; path4b & quot; )"></i></td></tr>
                    <tr><td></td><td align="center">
                            <select id="trans4a" name="trans4a"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td><td align="center">
                            <select id="trans4b" name="trans4b"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td></tr>
                    <tr><td></td><td align="center">
                            <select id="trans4c" name="trans4c"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td><td align="center">
                            <select id="trans4d" name="trans4d"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td></tr>
                </tbody></table>
        </div>
        <table class="table_box">
            <colgroup span="1" style="width:20px;"></colgroup><colgroup span="1" style="width:150px;"></colgroup><colgroup span="1" style="width:250px;"></colgroup>
            <tbody><tr><td><input type="checkbox" id="metric5" name="metric5" value="dice" onchange="showpaths(5)"></td><td>dice</td><td align="center"><input type="number" name="thre5" min="0" max="1" step="0.01" value="0.5"></td></tr>
            </tbody></table>
        <div id="path5" style="margin-left: -10px; display: none; background-color: rgb(245, 245, 245);">
            <table class="table_box">
                <colgroup span="1" style="width:20px;"></colgroup><colgroup span="1" style="width:150px;"></colgroup><colgroup span="1" style="width:250px;"></colgroup>
                <tbody><tr><td></td><td align="center"><i><input type="text" id="path5a" name="path5a" value="" onclick="erasePath( & quot; path5a & quot; )"></i></td><td align="center"><i><input type="text" id="path5b" name="path5b" value="" onclick="erasePath( & quot; path5b & quot; )"></i></td></tr>
                    <tr><td></td><td align="center">
                            <select id="trans5a" name="trans5a"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td><td align="center">
                            <select id="trans5b" name="trans5b"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td></tr>
                    <tr><td></td><td align="center">
                            <select id="trans5c" name="trans5c"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td><td align="center">
                            <select id="trans5d" name="trans5d"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td></tr>
                </tbody></table>
        </div>
        <table class="table_box">
            <colgroup span="1" style="width:20px;"></colgroup><colgroup span="1" style="width:150px;"></colgroup><colgroup span="1" style="width:250px;"></colgroup>
            <tbody><tr><td><input type="checkbox" id="metric6" name="metric6" value="softjaccard" onchange="showpaths(6)"></td><td>softjaccard</td><td align="center"><input type="number" name="thre6" min="0" max="1" step="0.01" value="0.5"></td></tr>
            </tbody></table>
        <div id="path6" style="margin-left: -10px; display: none; background-color: rgb(245, 245, 245);">
            <table class="table_box">
                <colgroup span="1" style="width:20px;"></colgroup><colgroup span="1" style="width:150px;"></colgroup><colgroup span="1" style="width:250px;"></colgroup>
                <tbody><tr><td></td><td align="center"><i><input type="text" id="path6a" name="path6a" value="" onclick="erasePath( & quot; path6a & quot; )"></i></td><td align="center"><i><input type="text" id="path6b" name="path6b" value="" onclick="erasePath( & quot; path6b & quot; )"></i></td></tr>
                    <tr><td></td><td align="center">
                            <select id="trans6a" name="trans6a"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td><td align="center">
                            <select id="trans6b" name="trans6b"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td></tr>
                    <tr><td></td><td align="center">
                            <select id="trans6c" name="trans6c"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td><td align="center">
                            <select id="trans6d" name="trans6d"><option value="">transformation</option>
                                <option value="removeBlanks">remove blanks</option>
                                <option value="removeSpecialChars">remove special chars</option>
                                <option value="lowerCase">lowerCase</option>
                                <option value="upperCase">upperCase</option>
                                <option value="capitalize">capitalize</option>
                                <option value="stem">stem</option>
                                <option value="alphaReduce">alpha reduce</option>
                                <option value="numReduce">num reduce</option>
                                <option value="replace">replace</option>
                                <option value="regexReplace">regex replace</option>
                                <option value="stripPrefix">strip prefix</option>
                                <option value="stripPostfix">strip postfix</option>
                                <option value="stripUriPrefix">strip Uri prefix</option>
                                <option value="concat">concat</option>
                                <option value="logarithm">logarithm</option>
                                <option value="convert">convert</option>
                                <option value="tokenize">tokenize</option>
                                <option value="removeValues">removeValues</option>
                                <option value="removeParentheses">remove parentheses</option></select>
                        </td></tr>
                </tbody></table>
        </div></div></div>