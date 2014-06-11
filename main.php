<?php
include_once ("./header.php");
?>
<div class="container">
    <br>
    <img width ="100%" src ="img/tcmlm_logo.jpg"></img> 
    <div class="container">

        <div class="panel panel-default">
            <div class="panel-heading lead">系统简介</div>
            <div class="panel-body">
                <p>中国中医科学院中医药信息研究所长期致力于中医文献的保护与利用工作，成功研制了大型的结构性文献数据库，
                    并于2012年代表我国向国际标准化组织（ISO）申请了为期两年的“中医文献元数据（简称TCMLM）”标准项目。
                    这是我国中医药信息标准项目在ISO中首次成功立项，具有突破性意义。 为促进该标准的研制、维护和推广工作，拟针对中医文献的特点，研发与TCMLM相互配合的本体和方法，构建TCMLM的示范应用。
                    在本系统中，还实现了一种简单的语义关系发现方法，作为中医文献知识发现的一次尝试。
                </p>
            </div>
        </div>  
        <div class="panel panel-default">
            <div class="panel-heading lead">系统功能</div>
            <div class="panel-body">

                <div class="row" align="center">
                    <div class="col-sm-6">
                        <a  href="index.php" target="_blank">
                            <img src="img/tcmlm_search1.jpg" width="80%" alt="...">
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="entity_search.php?db_name=tcmls">
                            <img width ="80%" src ="img/tcmlm-界面-党参.jpg"></img>
                        </a>   
                    </div>
                </div>
                <br>
                <div class="row"  align="center">

                    <div class="col-sm-6 ">
                        <p class="lead"><a href="index.php" target="_blank">文献检索</a></p>      
                        <p>该系统实现了基于文献元数据和关键词的文献检索功能。示例：   
                            <a href="resource_viewer.php?db_name=tcmlm&id=97">内经必读</a>                            
                            <a href="resource_viewer.php?db_name=tcmlm&id=134">本草纲目</a>   
                            <a href="search.php?keywords=内经&submit=&db_name=+tcmlm">内经</a>
                            <a href="resource_viewer.php?db_name=tcmlm&id=18">肘后备急方</a>
                            <a href="resource_viewer.php?db_name=tcmlm&id=190">扁鹊仓公传</a>
                            <a href="resource_viewer.php?db_name=tcmlm&id=334">素问</a>
                            <a href="resource_viewer.php?db_name=tcmlm&id=243">补遗雷公炮制</a>
                            <a href="resource_viewer.php?db_name=tcmlm&id=79">本草纲目拾遗</a>

                            <a href="search.php?keywords=李时珍&db_name=tcmlm">李时珍</a>            
                            <?php
                            $examples = array('柴胡', '丹参', '白花蛇舌草', '人参', '板蓝根', '党参', '三仁汤', '山药', '当归', '四君子汤', '大黄');
                            foreach ($examples as $ex) {
                                echo "<a href='search.php?keywords=$ex&db_name=tcmls'>$ex</a> ";
                            }
                            ?>                                            
                        </p>
                    </div>
                    <div class="col-sm-6 ">
                        <p class="lead"><a href="entity_search.php?db_name=tcmls" target="_blank">知识检索</a></p>   
                        <p>该系统将关于某个实体的知识综合呈现出来，并列出实体相关文献的列表。示例：                            
                            <?php
                            $examples = array('柴胡', '丹参', '白花蛇舌草', '板蓝根', '党参', '三仁汤', '山药', '当归', '四君子汤', '大黄', '柴胡桂枝干姜汤', '决明子粥', '清热平肝汤', '十三味榜嘎散', '五味子蜜丸', '乙癸丸', '滋阴养血汤');
                            foreach ($examples as $ex) {
                                echo "<a href='entity.php?name=$ex&db_name=tcmls'>$ex</a> ";
                            }
                            ?>
                        </p>
                    </div>
                </div>      
                <hr>

                <div class="row" align="center">
                    <div class="col-sm-6">
                        <a  href="resource_manager.php?db_name=tcmlm" target="_blank">
                            <img src="img/tcmlm_manager.jpg"  width="90%"  alt="...">
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a  href="relation_manager.php" target="_blank">
                            <img src="img/脾虚湿热证1.jpg"  width="80%" alt="...">
                        </a>                        
                    </div>
                </div>
                <br>

                <div class="row"  align="center">
                    <div class="col-sm-6">
                        <p class="lead"><a href="resource_manager.php?db_name=tcmlm" target="_blank">文献管理</a></p>
                        <p>该系统实现了基本的文献库管理功能，支持文献的录入、上传、下载和标注等功能。示例：<a href="resource_editor.php?db_name=tcmlm&id=73">《丹溪心法》</a>、 <a href="resource_editor.php?db_name=tcmlm&id=134">《本草纲目》</a>、<a href="resource_editor.php?db_name=tcmlm&id=97">《内经必读》</a>、<a href="resource_editor.php?db_name=tcmlm&id=190">《扁鹊仓公传》</a></p>

                    </div>
                    <div class="col-sm-6">
                        <p class="lead"><a href="relation_manager.php" target="_blank">文本语义关系发现</a></p>
                        <p>基于语言系统从文本中发现语义关系，并对其进行检索和浏览。示例：                            
                            <a href="relation_manager.php?keywords=人参"  target="_blank">人参</a>、&nbsp;
                            <a href="relation_manager.php?keywords=肾虚"  target="_blank">肾虚</a>、&nbsp;
                            <a href="relation_manager.php?keywords=虚火">虚火</a>、&nbsp;
                            <a href="relation_manager.php?keywords=脾虚">脾虚</a>、&nbsp;
                            <a href="relation.php?id=15436">脾虚+湿热证</a>
                            <a href="relation.php?id=19169">脾气虚+参苓白术散</a>
                            <a href="relation.php?id=22346">脾气虚+消瘦</a>
                            <a href="relation.php?id=45169">灵芝+担子菌亚门</a> 

                        </p>
                    </div>
                </div>      




            </div>
        </div>              
        <div class="panel panel-default">
            <div class="panel-heading lead">文献资源</div>
            <div class="panel-body">
                <div class="container">
                    <?php include_once ("./db_list.php"); ?>
                </div>                
                
            </div>
        </div>    
        <div class="panel panel-default">
            <div class="panel-heading lead">相关项目</div>
            <div class="panel-body">
                <div class="container">
                    <p class="lead"><a href="project_tcmlm.php">中医药文献元数据标准的示范应用与评价研究</a></p>
                    <p>本项目致力于研发中医药文献元数据标准的示范应用，开展该标准的评价研究。 中国中医科学院中医药信息研究所长期致力于中医文献的保护与利用工作，成功研制了64个的结构性文献数据库(方剂数据库,医案数据库)，并于2012年代表我国向国际标准化组织（ISO）申请了为期两年的“中医文献元数据（简称TCM-LM）”标准项目。这是我国中医药信息标准项目在ISO中首次成功立项，具有突破性意义。
                        为促进该标准的研制、维护和推广工作，拟针对中医文献的特点，采用国际先进的本体技术，研发与TCM-LM相互配合的本体和方法，构建TCM-LM的示范应用，对TCM-LM进行系统评价和适当改进。研究内容包括：（1）对TCM-LM与相关元数据标准进行比较分析，阐明TCM-LM的独特性和兼容性；（2）基于描述逻辑，构建符合TCM-LM标准的领域本体，通过机器推理来验证TCM-LM的逻辑严谨性；（3）研发与TCM-LM相配合的语义标注检索方法，验证TCM-LM标准的实用性；（4）基于上述研究结果和专家反馈意见，对TCM-LM标准进行适当改进。
                    </p> 
                    <hr>
                    <p class="lead"><a href="project_relation.php">基于文本的中医药语义关系发现研究</a></p>
                    <p>本项目致力于研究基于中医药学语言系统从中医药文献中提取语义关系的方法，为中医药学语言系统的建设提供新颖的技术手段。 中医药学语言系统是中国中医科学院中医药信息研究所于2002年起开始研制的一项大型中医药术语系统，语义网络是语言系统的重要组成部分。为了促进中医药学语言系统的发展，提高系统中语义关系的准确性，本课题拟进行基于文本的中医药语义关系发现研究，以求通过对中医药文献的文本进行分析，并与中医药学语言系统现有语义网络结合，得到准确的语义关系。
                        研究主要内容包括：（1）对目前中医药学语言系统语义网络进行分析，发现问题，并归纳得到基于语义类型层的语义关系网；（2）对中医药文献文本进行分析，发现获得语义关系，并归纳为基于语义类型的语义网络；（3）对文本获得的语义网络与目前的语义关系网进行比较，优化，形成新的语义网络。
                    </p>    
                    <hr>
                    <p class="lead"><a href="project_classics.php">基于文本信息抽取的中医古籍语义类型及语义关系研究</a></p>
                    <p>语言系统的建立是为了解决因为概念表述方式不统一和相关信息分散而造成的检索盲区。中医药学语言系统现代部分的构建已初具规模，可以支持文献检索和数据库建设，中医古籍语言系统也已经完成了框架的建设。中医古籍语言系统建设是一项长期的工作，其框架结构、语义类型、语义关系需要不断修订完善，方能真正成为沟通古今的桥梁。本研究以综合性医学著作《医学纲目》为试验文本，基于关键谓语动词进行文本的语义关系及相关实体词的抽取，完成《医学纲目》领域概念的半自动提取，以v-build编辑器为工具，以中医古籍语言系统以及传统针灸知识本体的语义类型、语义关系为基础，通过Python程序语言，完成语义类型间关系的提取，建立语言系统后期加工辅助工具，修订与完善语义类型及语义关系，为古籍语言系统的完善提供路径，为建立古籍知识体系的语义网络，实现知识点的链接，实现中医古籍知识的共享和重用奠定基础。
                    </p>      
                </div>
            </div>
        </div>    

    </div>
</div> 
<?php
include_once ("./foot.php");
?>
