<?php
include_once ("./header.php");
?>
<div class="container">
     <br>
    <img width ="100%" src ="img/tcmlm_project.jpg"></img>
    <div class="container">
        <br>
        <p align="center">
            <a class="btn btn-lg btn-success" href="ontologies/spleen-1.0.owl" role="button"><span class="glyphicon glyphicon-download"></span>&nbsp;下载本体</a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a class="btn btn-lg btn-primary" href="docs/spleen.docx" role="button"><span class="glyphicon glyphicon-download"></span>&nbsp;下载技术报告</a>
        </p>
        <hr>    
        <p class="lead"><strong>项目介绍</strong></p>        
        <p>中国中医科学院中医药信息研究所长期致力于中医文献的保护与利用工作，成功研制了大型的结构性文献数据库，并于2012年代表我国向国际标准化组织（ISO）申请了为期两年的“中医文献元数据（简称TCM-LM）”标准项目。
            这是我国中医药信息标准项目在ISO中首次成功立项，具有突破性意义。为促进该标准的研制、维护和推广工作，拟针对中医文献的特点，在分析“都柏林核心”等元数据标准的基础上，
            采用国际先进的本体和语义Web技术，研发与TCM-LM相互配合的本体和方法，构建TCM-LM的示范应用，对TCM-LM进行系统评价和适当改进。          
            研究内容包括：（1）对TCM-LM与相关元数据标准进行比较分析，阐明TCM-LM的独特性和兼容性；（2）基于描述逻辑，构建符合TCM-LM标准的领域本体，通过机器推理来验证TCM-LM的逻辑严谨性；（3）研发与TCM-LM相配合的语义标注、索引和检索方法，构建示范性的文献知识库和检索系统，验证TCM-LM标准的实用性；（4）基于上述研究结果和专家反馈意见，对TCM-LM标准进行适当改进。
        </p>
        <hr> 
        <p class="lead"><strong>示范应用</strong></p> 
        <p>我们以TCMLS中的词汇作为关键词，从“万方数据知识服务平台”中检出了217667万篇文献题录，存入一个MySQL数据库中，构成“TCMLS/万方文献库”。在“TCMLS/万方文献库”的基础上，实现了基于Web的<a href="index.php?db=tcmls" target="_blank">文献检索系统</a>和<a href="resource_manager.php?db_name=tcmls" target="_blank">文献管理系统</a>，支持基于关键词和实体的文献检索功能，以及文献的上传、录入和标注等功能。
            这样一个从万方数据知识服务平台中获取的中医药文献库，可以支持文本关系发现，文献标引等文本挖掘实验和文献检索应用，为后续工作奠定了基础。</p>
        <br>
        <div class="panel panel-default">
            <div class="container">
                <br>
                <br>
                <div class="row" align="center">
                    <div class="col-lg-offset-1 col-sm-6 col-md-5"> 
                        <div class="well-lg"></div>
                        <div class="well-lg"> <p class="lead"><strong>1. 从万方知识服务平台获取文献资源</strong></p> 
                            <p>我们以TCMLS中的词汇作为关键词，从“万方数据知识服务平台”中检出了217667万篇文献题录，存入一个MySQL数据库中，构成“TCML/万方文献库”。</p>
                        </div>

                    </div>
                    <div class="col-sm-6 col-md-5">              
                        <img width="100%" src ="img/文献库.jpg" alt="...">
                    </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="row" align="center">

                    <div class="col-lg-offset-1 col-sm-6 col-md-5">  
                        <div class="well-lg"></div>
                        <div class="well-lg"> <p class="lead"><strong>2. 实现基于Web的文献检索系统</strong></p> 
                            <p>该系统实现了基于关键词的文献检索功能。在界面左侧给出相关文献列表，在右侧则提供相关实体的结构性信息（来源包括TCMLS和中医药科学数据库）。下面举一些“文献检索界面”的例子：
                                <a href="search.php?db_name=tcmls&keywords=柴胡">柴胡</a> <a href="search.php?db_name=tcmls&keywords=丹参">丹参</a> <a href="search.php?db_name=tcmls&keywords=白花蛇舌草">白花蛇舌草</a> 
                                <a href="search.php?db_name=tcmls&keywords=板蓝根">板蓝根</a> <a href="search.php?db_name=tcmls&keywords=四君子汤">四君子汤</a>
                            </p>
                        </div>

                    </div>
                    <div class=" col-sm-6 col-md-5"> 
                        <a href="search.php?db_name=tcmls&keywords=四君子汤">
                            <img width ="100%" src ="img/tcmlm_search1.jpg"></img>
                        </a>    

                    </div>
                </div>
                <br>
                <hr>
                <br>

                <div class="row" align="center">

                    <div class="col-lg-offset-1 col-sm-6 col-md-5">  
                        <div class="well-lg"></div>
                        <div class="well-lg"> <p class="lead"><strong>3. 展示文献题录信息</strong></p> 
                            <p>该系统可展示文献的题名、作者、摘要、主题、来源等元信息。下面举一些“文献题录信息界面”的例子：</p>
                            <ul align="left">
                                <li><a href="resource_viewer.php?db_name=tcmlm&id=134">本草纲目</a></li>
                                <li><a href="resource_viewer.php?db_name=tcmlm&id=18">肘后备急方</a></li>    
                                <li><a href="resource_viewer.php?db_name=tcmlm&id=243">补遗雷公炮制</a></li>                             
                                <li><a href="resource_viewer.php?db_name=tcmls&id=49023">《伤寒论》的人参应用规律研究</a></li>
                                <li><a href="resource_viewer.php?db_name=tcmls&id=30991">论实证胃痛之四治法</a></li>
                                <li><a href="resource_viewer.php?db_name=tcmls&id=64990">"脾虚生五邪"证治</a></li>                       
                            </ul>
                        </div>
                    </div>
                    <div class=" col-sm-6 col-md-5"> 
                        <a href="resource_viewer.php?db_name=tcmlm&id=134">
                            <img width ="100%" src ="img/metadata-本草纲目.jpg"></img>
                        </a>    

                    </div>
                </div>

                <br>
                <hr>
                <br>
                <div class="row" align="center">

                    <div class="col-lg-offset-1 col-sm-6 col-md-5">  
                        <div class="well-lg"></div>
                        <div class="well-lg"> <p class="lead"><strong>4. 综合呈现实体的信息</strong></p> 
                            <p>该系统将TCMLS和中医药科学数据库中关于某个实体的知识综合呈现出来，在下方则列出了实体相关文献的列表。
                                下面举一些“实体信息界面”的例子：

                                <?php
                                $examples = array('柴胡', '丹参', '白花蛇舌草', '板蓝根', '党参', '三仁汤', '山药', '当归', '四君子汤', '大黄', '柴胡桂枝干姜汤', '决明子粥', '清热平肝汤', '十三味榜嘎散', '五味子蜜丸', '乙癸丸', '滋阴养血汤');
                                foreach ($examples as $ex) {
                                    echo "<a href='entity.php?name=$ex&db_name=tcmls'>$ex</a> ";
                                }
                                ?>


                            </p>
                        </div>

                    </div>
                    <div class=" col-sm-6 col-md-5"> 
                        <a href="entity.php?name=党参&db_name=tcmls">
                            <img width ="100%" src ="img/tcmlm-界面-党参.jpg"></img>
                        </a>    

                    </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="row" align="center">

                    <div class="col-lg-offset-1 col-sm-6 col-md-5">  
                        <div class="well-lg"></div>
                        <div class="well-lg"> <p class="lead"><strong>5. 基于Web的文献管理系统</strong></p> 
                            <p>该系统实现了基本的文献库管理功能，支持文献的录入、上传、下载和标注等功能。示例：<a href="resource_editor.php?db_name=tcmlm&id=73">《丹溪心法》</a>、 <a href="resource_editor.php?db_name=tcmlm&id=134">《本草纲目》</a>、<a href="resource_editor.php?db_name=tcmlm&id=97">《内经必读》</a>、<a href="resource_editor.php?db_name=tcmlm&id=190">《扁鹊仓公传》</a></p>
                        </div>

                    </div>
                    <div class=" col-sm-6 col-md-5"> 
                        <a  href="resource_manager.php?db_name=tcmlm" target="_blank">
                            <img src="img/tcmlm_manager.jpg"  width="90%"  alt="...">
                        </a>
                    </div>
                </div>
                <br>

                <br>
            </div>
        </div>
    </div>
    <hr>
    <p class="lead"><strong>小结</strong></p> 
    <p>
        ISO是产生于西方文化影响下的国际组织,具有中华文化特色的标准项目得以立足，需要跨越东、西方文化鸿沟，必将面临许多新问题、新挑战。这些问题不仅局限于规则和技术层面，也涉及到根本性的原理问题,此前一些 专家认为ISO TC215旨在关注健康信息，不是从具体的医学角度出发制定标准的，因此中医药信息标准不具备独特性。此次TCM-LM作为中医药信息标准在ISO TC215中首次成功立项，具有突破性意义。
        目前，国际上尚未形成被普遍推广的中医文献元数据标准，TCM-LM的草案刚刚形成，尚待完善；尚未出现与之配合的中医文献处理方法，其示范应用和系统评价研究亦处于空白。作为国际首个TCM-LM的应用和评价研究，本项目研究该标准的示范应用，评估该标准的合理性与实用性，纳入到国际标准的必要性和重要性，及其在中医药文献管理及检索中发挥的作用，为标准提案和答辩工作提供
        6 / 16
        定性、定量的证据。TCM-LM的示范应用、专利和研究报告，将充实中医文献元数据的规范体系。若TCM-LM得到通过，则将是ISO/TC215中首批中医药信息学领域的项目，使得中医药信息标准在国际医疗信息标准中占据一席之地。
    </p>

 <hr>

</div> <!-- /container -->

<?php
include_once ("./foot.php");
?>