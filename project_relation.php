<?php
include_once ("./header.php");
?>
<div class="container">
    <img width ="100%" src ="img/tcmls_text_mining.jpg"></img>    
    <div  class="container">
        <p class="lead"><strong>项目介绍</strong></p>        
        <p>中医药学语言系统是中国中医科学院中医药信息研究所于2002年起开始研制的一项大型中医药术语系统，语义网络是语言系统的重要组成部分。为了促进中医药学语言系统的发展，提高系统中语义关系的准确性，本课题拟进行基于文本的中医药语义关系发现研究，以求通过对中医药文献的文本进行分析，并与中医药学语言系统现有语义网络结合，得到准确的语义关系。</p>
        <p>在本项目中，我们主要完成了3项工作：
        <ol>
            <li>基于TCMLS从文本中抽取语义关系，构成了一个“文献库”；</li>                
            <li>从“文献库”和TCMLS中，分别归纳出基于语义类型的语义网络(即“顶层语义网络”)；</li>
            <li>将“文献库”和TCMLS的顶层语义网络进行比较。</li>  
        </ol> 
        在此介绍从文本中抽取语义关系的方法；欲知语义网络的归纳、浏览和比较的方法和结果，请点击&nbsp;<a href="/LOD/doc_tcmls_text_mining.php">这里&nbsp;》</a>
        </p>
        <hr>
        <p class="lead"><strong>从万方知识服务平台获取文献资源</strong></p> 
        <p>我们以TCMLS中的词汇作为关键词，从“万方数据知识服务平台”中检出了20余万篇文献题录，存入一个MySQL数据库中，构成“中医药文献库”。在“中医药文献库”的基础上，实现了<a href="index.php?db=tcmls">基于Web的文献检索系统</a>，支持基于关键词的文献检索功能。这样一个从万方数据知识服务平台中获取的中医药文献库，可以支持文本关系发现，文献标引等文本挖掘实验和文献检索应用，为后续工作奠定了基础。</p>
        <p>详见<a href="docs/于彤-基于文本挖掘发现中医药语义关系的方法探索研究-2013.12.27.docx" role="button">技术报告</a></p>
        <hr>
        <p align="center">
            <a class="btn btn-lg btn-success" href="docs/文本语义关系平台用户手册v2.docx" role="button"><span class="glyphicon glyphicon-download"></span>&nbsp;下载用户手册</a>
            <a class="btn btn-lg btn-primary" href="docs/于彤-基于文本挖掘发现中医药语义关系的方法探索研究-2013.12.27.docx" role="button"><span class="glyphicon glyphicon-download"></span>&nbsp;下载技术报告</a>
        </p>
    </div>
</div> <!-- /container -->

<?php
include_once ("./foot.php");
?>