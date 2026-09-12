<?php
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

require_once __DIR__ . '/../includes/helpers.php';

$assetVersion = (string)round(microtime(true) * 1000);
$diagramBase = 'assets/diagrams/';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="SmartOps AI — RAG-LLM powered operational maintenance intelligence, demonstrated through an end-to-end hotel maintenance workflow.">
  <meta name="theme-color" content="#071426">
  <title>SmartOps AI | Operational Maintenance Intelligence</title>
  <link rel="stylesheet" href="assets/presentation.css?v=<?= e($assetVersion) ?>">
<style id="smartopsRagRedesignStyles">

/* ==========================================================
   MAIN SECTION
========================================================== */

.smartops-rag-section{
    position:relative;
    overflow:visible;
}

/* Keep the original presentation rhythm; chapter navigation is the entry point. */
.smartops-rag-section .rag-executive-intro{
    display:none;
}

.smartops-rag-section::before{
    content:"";
    position:absolute;
    width:700px;
    height:700px;
    right:-320px;
    top:220px;
    border-radius:50%;
    background:
        radial-gradient(
            circle,
            rgba(30,155,255,.12),
            rgba(30,155,255,0) 68%
        );
    pointer-events:none;
}

.smartops-rag-section::after{
    content:"";
    position:absolute;
    width:520px;
    height:520px;
    left:-260px;
    bottom:220px;
    border-radius:50%;
    background:
        radial-gradient(
            circle,
            rgba(29,213,175,.07),
            rgba(29,213,175,0) 68%
        );
    pointer-events:none;
}


/* ==========================================================
   EXECUTIVE INTRODUCTION
========================================================== */

.rag-executive-intro{
    position:relative;
    z-index:1;
    display:grid;
    grid-template-columns:1.05fr .95fr;
    gap:26px;
    margin-top:34px;
    padding:28px;
    border:1px solid rgba(104,188,255,.18);
    border-radius:24px;
    background:
        linear-gradient(
            135deg,
            rgba(12,43,72,.96),
            rgba(6,23,41,.98)
        );
    box-shadow:
        0 30px 80px rgba(0,0,0,.22),
        inset 0 1px rgba(255,255,255,.03);
    overflow:hidden;
}

.rag-executive-intro::before{
    content:"";
    position:absolute;
    inset:0;
    background:
        linear-gradient(
            90deg,
            rgba(69,175,255,.05) 1px,
            transparent 1px
        ),
        linear-gradient(
            rgba(69,175,255,.05) 1px,
            transparent 1px
        );
    background-size:34px 34px;
    mask-image:
        linear-gradient(
            to right,
            rgba(0,0,0,.7),
            transparent 85%
        );
    pointer-events:none;
}

.rag-executive-copy{
    position:relative;
    z-index:2;
    padding:10px;
}

.rag-small-label{
    display:block;
    color:#5ac9ff;
    font-size:10px;
    font-weight:900;
    letter-spacing:.17em;
}

.rag-executive-copy h3{
    max-width:690px;
    margin:12px 0 14px;
    color:#f4f9ff;
    font-size:clamp(28px,3vw,44px);
    line-height:1.05;
    letter-spacing:-.03em;
}

.rag-executive-copy p{
    max-width:680px;
    margin:0;
    color:#9fb5c9;
    font-size:14px;
    line-height:1.75;
}

.rag-executive-points{
    display:flex;
    flex-wrap:wrap;
    gap:9px;
    margin-top:22px;
}

.rag-executive-points span{
    display:flex;
    align-items:center;
    gap:8px;
    padding:10px 12px;
    border:1px solid rgba(101,187,255,.16);
    border-radius:10px;
    background:rgba(4,19,35,.42);
    color:#cfe8fa;
    font-size:14px;
    font-weight:700;
}

.rag-executive-points i{
    color:#5acaff;
    font-style:normal;
    font-size:9px;
    font-weight:900;
}

.rag-executive-visual{
    position:relative;
    min-height:360px;
    display:grid;
    place-items:center;
}

.rag-visual-grid{
    position:absolute;
    inset:0;
    border-radius:18px;
    background:
        radial-gradient(
            circle at center,
            rgba(58,178,255,.12),
            transparent 54%
        );
}

.rag-core-orbit{
    position:relative;
    width:285px;
    height:285px;
    display:grid;
    place-items:center;
    border:1px solid rgba(83,189,255,.28);
    border-radius:50%;
    box-shadow:
        0 0 50px rgba(41,154,255,.12),
        inset 0 0 45px rgba(39,163,255,.06);
}

.rag-core-orbit::before,
.rag-core-orbit::after{
    content:"";
    position:absolute;
    border-radius:50%;
}

.rag-core-orbit::before{
    inset:30px;
    border:1px dashed rgba(95,196,255,.22);
}

.rag-core-orbit::after{
    inset:68px;
    border:1px solid rgba(61,218,179,.18);
}

.rag-core-circle{
    position:relative;
    z-index:3;
    width:130px;
    height:130px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    border:1px solid rgba(93,194,255,.45);
    border-radius:50%;
    background:
        radial-gradient(
            circle at 40% 32%,
            rgba(72,185,255,.25),
            rgba(5,24,43,.96) 62%
        );
    box-shadow:
        0 0 50px rgba(54,172,255,.18);
}

.rag-core-circle small{
    color:#67cdff;
    font-size:8px;
    font-weight:900;
    letter-spacing:.14em;
}

.rag-core-circle strong{
    margin-top:4px;
    color:#f0f8ff;
    font-size:29px;
    line-height:1;
}

.rag-core-circle b{
    color:#64e3c1;
    font-size:17px;
    line-height:1;
}

.rag-orbit-label{
    position:absolute;
    padding:7px 10px;
    border:1px solid rgba(92,187,255,.18);
    border-radius:999px;
    background:#0a2744;
    color:#bde5ff;
    font-size:9px;
    font-weight:900;
    letter-spacing:.1em;
}

.rag-orbit-label.top{
    top:-14px;
}

.rag-orbit-label.right{
    right:-28px;
}

.rag-orbit-label.bottom{
    bottom:-14px;
}

.rag-orbit-label.left{
    left:-22px;
}


/* ==========================================================
   STAGE HEADER
========================================================== */

.rag-stage-header{
    display:flex;
    justify-content:space-between;
    gap:25px;
    align-items:flex-end;
    margin-top:48px;
}

.rag-stage-header span{
    display:block;
    color:#54c7ff;
    font-size:10px;
    font-weight:900;
    letter-spacing:.15em;
}

.rag-stage-header h3{
    margin:7px 0 0;
    color:#f0f7ff;
    font-size:25px;
}

.rag-stage-header p{
    max-width:540px;
    margin:0;
    color:#8fa8bc;
    font-size:12px;
    line-height:1.6;
}


/* ==========================================================
   STAGE NAVIGATION
========================================================== */

.rag-stage-navigation{
    display:grid;
    grid-template-columns:repeat(6,1fr);
    gap:10px;
    margin-top:17px;
}

.rag-stage-button{
    position:relative;
    min-height:138px;
    display:flex;
    flex-direction:column;
    align-items:flex-start;
    gap:13px;
    padding:17px;
    border:1px solid rgba(102,184,255,.15);
    border-radius:14px;
    background:
        linear-gradient(
            150deg,
            rgba(12,42,69,.78),
            rgba(6,24,42,.92)
        );
    color:inherit;
    text-align:left;
    cursor:pointer;
    overflow:hidden;
    transition:
        transform .2s ease,
        border-color .2s ease,
        background .2s ease;
}

.rag-stage-button::after{
    content:"";
    position:absolute;
    left:0;
    right:0;
    bottom:0;
    height:3px;
    background:
        linear-gradient(
            90deg,
            #3eacff,
            #48e0bb
        );
    transform:scaleX(0);
    transform-origin:left;
    transition:transform .2s ease;
}

.rag-stage-button:hover{
    transform:translateY(-3px);
    border-color:rgba(92,190,255,.34);
}

.rag-stage-button.active{
    border-color:rgba(81,190,255,.48);
    background:
        linear-gradient(
            145deg,
            rgba(18,74,113,.94),
            rgba(7,31,52,.96)
        );
    box-shadow:
        0 18px 45px rgba(0,0,0,.18),
        inset 0 1px rgba(255,255,255,.04);
}

.rag-stage-button.active::after{
    transform:scaleX(1);
}

.stage-index{
    display:grid;
    place-items:center;
    width:34px;
    height:34px;
    border:1px solid rgba(99,195,255,.22);
    border-radius:9px;
    background:rgba(48,161,235,.10);
    color:#63cbff;
    font-size:10px;
    font-weight:900;
}

.stage-copy{
    display:block;
}

.stage-copy small,
.stage-copy strong,
.stage-copy em{
    display:block;
}

.stage-copy small{
    color:#5bc8ff;
    font-size:8px;
    font-weight:900;
    letter-spacing:.1em;
}

.stage-copy strong{
    margin-top:6px;
    color:#edf7ff;
    font-size:13px;
}

.stage-copy em{
    margin-top:6px;
    color:#7f9bb1;
    font-size:9px;
    font-style:normal;
    line-height:1.45;
}


/* ==========================================================
   MAIN TABS
========================================================== */

.rag-main-tabs{
    margin-top:28px;
}


/* ==========================================================
   CHAPTER
========================================================== */

.rag-framework-panel{
    position:relative;
}

.rag-chapter{
    display:none;
    margin-top:19px;
    padding:27px;
    border:1px solid rgba(100,184,255,.15);
    border-radius:20px;
    background:
        linear-gradient(
            145deg,
            rgba(8,31,53,.96),
            rgba(5,21,38,.98)
        );
    box-shadow:
        0 28px 70px rgba(0,0,0,.20),
        inset 0 1px rgba(255,255,255,.025);
}

.rag-chapter.active{
    display:block;
    animation:ragChapterIn .34s ease both;
}

@keyframes ragChapterIn{
    from{
        opacity:0;
        transform:translateY(8px);
    }

    to{
        opacity:1;
        transform:none;
    }
}

.rag-chapter-heading{
    display:flex;
    justify-content:space-between;
    gap:24px;
    padding-bottom:20px;
    border-bottom:1px solid rgba(105,184,255,.12);
}

.rag-chapter-code{
    display:block;
    color:#57c9ff;
    font-size:9px;
    font-weight:900;
    letter-spacing:.15em;
}

.rag-chapter-heading h3{
    margin:8px 0 10px;
    color:#f2f8ff;
    font-size:28px;
    letter-spacing:-.02em;
}

.rag-chapter-heading p{
    max-width:760px;
    margin:0;
    color:#91aabd;
    font-size:13px;
    line-height:1.65;
}

.rag-chapter-status{
    flex:0 0 auto;
    display:flex;
    align-items:center;
    gap:8px;
    height:fit-content;
    padding:9px 12px;
    border:1px solid rgba(78,205,167,.18);
    border-radius:999px;
    background:rgba(26,151,116,.08);
    color:#68e0bb;
    font-size:8px;
    font-weight:900;
    letter-spacing:.1em;
}

.rag-chapter-status span{
    width:7px;
    height:7px;
    border-radius:50%;
    background:#53d8ad;
    box-shadow:0 0 12px rgba(83,216,173,.65);
}


/* ==========================================================
   GENERAL CHAPTER LAYOUT
========================================================== */

.rag-chapter-grid{
    display:grid;
    grid-template-columns:.95fr 1.05fr;
    gap:18px;
    margin-top:22px;
}

.rag-content-card,
.rag-system-card{
    min-height:430px;
    padding:22px;
    border:1px solid rgba(100,184,255,.13);
    border-radius:16px;
    background:
        linear-gradient(
            145deg,
            rgba(11,42,69,.74),
            rgba(6,24,42,.92)
        );
}

.rag-card-label{
    color:#5ccaff;
    font-size:9px;
    font-weight:900;
    letter-spacing:.13em;
}

.rag-content-card h4{
    margin:9px 0 10px;
    color:#eff7ff;
    font-size:22px;
}

.rag-content-card > p{
    margin:0;
    color:#8da6b9;
    font-size:12px;
    line-height:1.65;
}


/* ==========================================================
   INFORMATION LIST
========================================================== */

.rag-information-list{
    display:grid;
    gap:10px;
    margin-top:20px;
}

.rag-information-list > div{
    display:grid;
    grid-template-columns:39px 1fr;
    gap:11px;
    padding:13px;
    border:1px solid rgba(99,181,255,.12);
    border-radius:10px;
    background:rgba(4,20,36,.38);
}

.rag-information-list > div > span{
    display:grid;
    place-items:center;
    width:34px;
    height:34px;
    border-radius:8px;
    background:rgba(57,168,242,.10);
    color:#61cbff;
    font-size:9px;
    font-weight:900;
}

.rag-information-list strong,
.rag-information-list small{
    display:block;
}

.rag-information-list strong{
    color:#dcecf8;
    font-size:12px;
}

.rag-information-list small{
    margin-top:4px;
    color:#7893a8;
    font-size:10px;
    line-height:1.45;
}


/* ==========================================================
   ROUTING
========================================================== */

.rag-routing-example{
    height:100%;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.rag-routing-message,
.rag-model-block{
    padding:18px;
    border:1px solid rgba(96,187,255,.18);
    border-radius:13px;
    background:rgba(6,27,47,.72);
}

.rag-routing-message small,
.rag-model-block > span{
    display:block;
    color:#5bcaff;
    font-size:8px;
    font-weight:900;
    letter-spacing:.12em;
}

.rag-routing-message p{
    margin:8px 0 0;
    color:#e4f2fc;
    font-size:14px;
    line-height:1.55;
}

.rag-vertical-arrow{
    padding:9px 0;
    color:#57c9ff;
    font-weight:900;
    text-align:center;
}

.rag-model-block{
    display:flex;
    flex-wrap:wrap;
    align-items:center;
    justify-content:center;
    gap:9px;
}

.rag-model-block > span{
    width:100%;
    text-align:center;
}

.rag-model-block strong{
    padding:10px 12px;
    border:1px solid rgba(95,183,255,.16);
    border-radius:9px;
    background:rgba(52,155,222,.08);
    color:#d9efff;
    font-size:12px;
}

.rag-model-block b{
    color:#58c9ff;
}

.rag-category-output{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:8px;
}

.rag-category-output span{
    padding:11px;
    border:1px solid rgba(100,184,255,.13);
    border-radius:8px;
    background:rgba(5,23,40,.64);
    color:#809caf;
    font-size:10px;
    font-weight:800;
    text-align:center;
}

.rag-category-output span.selected{
    border-color:rgba(69,219,174,.42);
    background:rgba(35,169,131,.11);
    color:#66e2bb;
}

.rag-category-output span.other{
    border-color:rgba(234,94,94,.22);
    color:#ef8b8b;
}

.rag-policy-strip{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:12px;
    margin-top:16px;
}

.rag-policy-strip > div{
    display:flex;
    gap:12px;
    align-items:center;
    padding:14px 16px;
    border:1px solid;
    border-radius:12px;
}

.rag-policy-strip > div > span{
    display:grid;
    place-items:center;
    width:34px;
    height:34px;
    border-radius:50%;
    font-weight:900;
}

.rag-policy-strip small,
.rag-policy-strip strong{
    display:block;
}

.rag-policy-strip small{
    font-size:8px;
    font-weight:900;
    letter-spacing:.1em;
}

.rag-policy-strip strong{
    margin-top:4px;
    font-size:11px;
}

.rag-policy-strip .proceed{
    border-color:rgba(59,214,169,.25);
    background:rgba(31,145,110,.08);
}

.rag-policy-strip .proceed > span{
    background:rgba(51,205,159,.12);
    color:#62e2b8;
}

.rag-policy-strip .proceed small{
    color:#58d9af;
}

.rag-policy-strip .proceed strong{
    color:#dffbf1;
}

.rag-policy-strip .stop{
    border-color:rgba(236,88,88,.24);
    background:rgba(165,44,44,.07);
}

.rag-policy-strip .stop > span{
    background:rgba(224,71,71,.11);
    color:#f18484;
}

.rag-policy-strip .stop small{
    color:#e87979;
}

.rag-policy-strip .stop strong{
    color:#f5dede;
}


/* ==========================================================
   FEATURE STACK
========================================================== */

.rag-feature-stack{
    display:grid;
    gap:10px;
    margin-top:20px;
}

.rag-feature-stack > div{
    display:flex;
    gap:11px;
    align-items:flex-start;
    padding:13px;
    border:1px solid rgba(99,183,255,.12);
    border-radius:10px;
    background:rgba(5,21,38,.46);
}

.rag-feature-stack i{
    display:grid;
    place-items:center;
    flex:0 0 34px;
    width:34px;
    height:34px;
    border:1px solid rgba(94,190,255,.17);
    border-radius:8px;
    background:rgba(59,169,240,.08);
    color:#5bcaff;
    font-style:normal;
    font-size:10px;
    font-weight:900;
}

.rag-feature-stack strong,
.rag-feature-stack small{
    display:block;
}

.rag-feature-stack strong{
    color:#dbeaf6;
    font-size:12px;
}

.rag-feature-stack small{
    margin-top:4px;
    color:#7893a9;
    font-size:10px;
    line-height:1.45;
}


/* ==========================================================
   BUSINESS BUTTON
========================================================== */

.rag-business-button{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:12px;
    margin-top:20px;
    padding:12px 15px;
    border:1px solid rgba(89,190,255,.25);
    border-radius:10px;
    background:
        linear-gradient(
            135deg,
            rgba(36,137,211,.95),
            rgba(24,105,177,.95)
        );
    color:#fff;
    font-size:10px;
    font-weight:900;
    letter-spacing:.03em;
    cursor:pointer;
    box-shadow:0 12px 30px rgba(24,115,190,.16);
    transition:
        transform .18s ease,
        filter .18s ease;
}

.rag-business-button:hover{
    transform:translateY(-2px);
    filter:brightness(1.08);
}

.rag-business-button.secondary{
    background:rgba(255,255,255,.04);
    border-color:rgba(101,188,255,.20);
    color:#c9e7fa;
}


/* ==========================================================
   PARENT CHILD ARCHITECTURE
========================================================== */

.rag-parent-child-architecture{
    height:100%;
    display:flex;
    flex-direction:column;
    justify-content:center;
    gap:13px;
}

.rag-parent-card,
.rag-child-card{
    padding:18px;
    border:1px solid;
    border-radius:13px;
}

.rag-parent-card{
    border-color:rgba(85,190,255,.42);
    background:
        linear-gradient(
            145deg,
            rgba(30,113,172,.20),
            rgba(6,27,46,.82)
        );
    box-shadow:0 18px 45px rgba(0,0,0,.13);
}

.rag-parent-card small,
.rag-child-card small{
    display:block;
    font-size:8px;
    font-weight:900;
    letter-spacing:.11em;
}

.rag-parent-card small{
    color:#61ccff;
}

.rag-parent-card strong,
.rag-child-card strong{
    display:block;
    margin-top:7px;
    color:#eef8ff;
    font-size:15px;
}

.rag-parent-card span,
.rag-child-card span{
    display:block;
    margin-top:6px;
    color:#839daf;
    font-size:10px;
}

.rag-link-line{
    display:flex;
    align-items:center;
    gap:10px;
}

.rag-link-line span{
    flex:1;
    height:1px;
    background:rgba(85,190,255,.20);
}

.rag-link-line b{
    color:#5ac9ff;
    font-size:8px;
    letter-spacing:.09em;
}

.rag-child-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
}

.rag-child-card.troubleshooting{
    border-color:rgba(63,216,175,.27);
    background:rgba(30,142,108,.07);
}

.rag-child-card.troubleshooting small{
    color:#5bdcb5;
}

.rag-child-card.preventive{
    border-color:rgba(151,121,255,.28);
    background:rgba(110,78,190,.07);
}

.rag-child-card.preventive small{
    color:#af9bff;
}

.rag-indexing-rule{
    display:flex;
    flex-wrap:wrap;
    align-items:center;
    justify-content:center;
    gap:7px;
    padding:13px;
    border:1px solid rgba(99,183,255,.13);
    border-radius:11px;
    background:rgba(3,18,33,.54);
}

.rag-indexing-rule span{
    display:grid;
    place-items:center;
    width:24px;
    height:24px;
    border-radius:6px;
    background:rgba(53,162,235,.10);
    color:#5ccaff;
    font-size:8px;
    font-weight:900;
}

.rag-indexing-rule strong{
    color:#cce4f4;
    font-size:9px;
}

.rag-indexing-rule b{
    color:#56c8ff;
}


/* ==========================================================
   RETRIEVAL BOARD
========================================================== */

.rag-retrieval-board{
    display:flex;
    flex-wrap:wrap;
    align-items:center;
    justify-content:center;
    gap:10px;
    margin-top:22px;
    padding:25px;
    border:1px solid rgba(99,184,255,.13);
    border-radius:17px;
    background:
        radial-gradient(
            circle at center,
            rgba(42,140,206,.08),
            transparent 58%
        ),
        rgba(4,20,36,.46);
}

.rag-retrieval-node,
.rag-parallel-search > div{
    min-width:135px;
    padding:17px 15px;
    border:1px solid rgba(98,184,255,.16);
    border-radius:12px;
    background:
        linear-gradient(
            145deg,
            rgba(12,44,72,.88),
            rgba(6,25,43,.94)
        );
    text-align:center;
}

.rag-retrieval-node small,
.rag-parallel-search small{
    display:block;
    color:#5ac9ff;
    font-size:8px;
    font-weight:900;
    letter-spacing:.1em;
}

.rag-retrieval-node strong,
.rag-parallel-search strong{
    display:block;
    margin-top:7px;
    color:#eef8ff;
    font-size:14px;
}

.rag-retrieval-node span,
.rag-parallel-search span{
    display:block;
    margin-top:6px;
    color:#7d98ad;
    font-size:9px;
}

.rag-parallel-search{
    display:grid;
    gap:8px;
}

.rag-parallel-search > div:first-child{
    border-color:rgba(81,180,255,.30);
}

.rag-parallel-search > div:last-child{
    border-color:rgba(54,213,177,.26);
}

.rag-flow-arrow{
    color:#5bcaff;
    font-weight:900;
}

.rag-selected-result{
    display:flex;
    justify-content:space-between;
    gap:20px;
    align-items:center;
    margin-top:15px;
    padding:17px 19px;
    border:1px solid rgba(57,217,170,.23);
    border-radius:13px;
    background:
        linear-gradient(
            120deg,
            rgba(31,145,108,.11),
            rgba(5,25,42,.82)
        );
}

.rag-selected-result small,
.rag-selected-result strong,
.rag-selected-result span{
    display:block;
}

.rag-selected-result small{
    color:#5bdcb4;
    font-size:8px;
    font-weight:900;
    letter-spacing:.1em;
}

.rag-selected-result strong{
    margin-top:6px;
    color:#ecfff8;
    font-size:15px;
}

.rag-selected-result span{
    margin-top:4px;
    color:#88aa9d;
    font-size:10px;
}

.rag-selected-result .rag-business-button{
    margin-top:0;
}


/* ==========================================================
   SIGNALS
========================================================== */

.rag-signal-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:9px;
    margin-top:20px;
}

.rag-signal-grid span{
    padding:13px;
    border:1px solid rgba(99,184,255,.13);
    border-radius:10px;
    background:rgba(4,21,37,.47);
    color:#c7e2f2;
    font-size:10px;
    font-weight:700;
}

.rag-signal-grid span:last-child{
    grid-column:1 / -1;
}


/* ==========================================================
   GATE
========================================================== */

.rag-gate-visual{
    height:100%;
    display:grid;
    grid-template-columns:.92fr 1.08fr;
    gap:18px;
    align-items:center;
}

.rag-gauge{
    position:relative;
    width:230px;
    height:230px;
    margin:auto;
    display:grid;
    place-items:center;
    border-radius:50%;
    background:
        radial-gradient(
            circle,
            rgba(11,45,73,.96) 0 48%,
            transparent 49%
        );
}

.gauge-arc{
    position:absolute;
    inset:0;
    border-radius:50%;
    background:
        conic-gradient(
            from 220deg,
            #e45454 0deg 70deg,
            #e4aa45 70deg 135deg,
            #48d5aa 135deg 220deg,
            transparent 220deg 360deg
        );
    mask:
        radial-gradient(
            farthest-side,
            transparent calc(100% - 18px),
            #000 0
        );
}

.gauge-needle{
    position:absolute;
    width:77px;
    height:3px;
    left:50%;
    top:50%;
    border-radius:999px;
    background:#dff5ff;
    transform-origin:left center;
    transform:rotate(-38deg);
    box-shadow:0 0 12px rgba(217,246,255,.45);
}

.rag-gauge > div{
    position:relative;
    z-index:2;
    text-align:center;
}

.rag-gauge small,
.rag-gauge strong{
    display:block;
}

.rag-gauge small{
    color:#5fcaff;
    font-size:8px;
    letter-spacing:.12em;
}

.rag-gauge strong{
    margin-top:5px;
    color:#f0f8ff;
    font-size:13px;
}

.rag-gate-outcomes{
    display:grid;
    gap:9px;
}

.rag-gate-outcomes > div{
    display:flex;
    gap:11px;
    align-items:center;
    padding:13px;
    border:1px solid;
    border-radius:11px;
}

.rag-gate-outcomes > div > span{
    display:grid;
    place-items:center;
    width:33px;
    height:33px;
    border-radius:50%;
    font-weight:900;
}

.rag-gate-outcomes small,
.rag-gate-outcomes strong{
    display:block;
}

.rag-gate-outcomes small{
    font-size:8px;
    letter-spacing:.1em;
}

.rag-gate-outcomes strong{
    margin-top:3px;
    font-size:11px;
}

.rag-gate-outcomes .ready{
    border-color:rgba(54,218,168,.24);
    background:rgba(27,142,106,.08);
}

.rag-gate-outcomes .ready > span{
    background:rgba(52,210,163,.12);
    color:#61e1b6;
}

.rag-gate-outcomes .ready small{
    color:#57d8ad;
}

.rag-gate-outcomes .ready strong{
    color:#dcf9ef;
}

.rag-gate-outcomes .review{
    border-color:rgba(232,169,65,.25);
    background:rgba(184,115,20,.08);
}

.rag-gate-outcomes .review > span{
    background:rgba(224,153,49,.12);
    color:#efb656;
}

.rag-gate-outcomes .review small{
    color:#e7ad4f;
}

.rag-gate-outcomes .review strong{
    color:#f8ebd2;
}

.rag-gate-outcomes .blocked{
    border-color:rgba(233,83,83,.25);
    background:rgba(164,43,43,.08);
}

.rag-gate-outcomes .blocked > span{
    background:rgba(222,70,70,.12);
    color:#ef7a7a;
}

.rag-gate-outcomes .blocked small{
    color:#e77070;
}

.rag-gate-outcomes .blocked strong{
    color:#f6dede;
}


/* ==========================================================
   PROMPT RULES
========================================================== */

.rag-prompt-rules{
    display:grid;
    gap:9px;
    margin-top:20px;
}

.rag-prompt-rules > div{
    display:flex;
    gap:10px;
    align-items:center;
    padding:12px;
    border:1px solid rgba(99,184,255,.12);
    border-radius:9px;
    background:rgba(4,21,37,.47);
}

.rag-prompt-rules span{
    color:#5dcaff;
    font-size:9px;
    font-weight:900;
}

.rag-prompt-rules strong{
    color:#cce4f4;
    font-size:10px;
}


/* ==========================================================
   JSON
========================================================== */

.rag-json-card{
    height:100%;
    display:flex;
    flex-direction:column;
    border:1px solid rgba(95,184,255,.17);
    border-radius:14px;
    background:#03111f;
    overflow:hidden;
}

.rag-json-head{
    display:flex;
    gap:12px;
    align-items:center;
    padding:15px;
    border-bottom:1px solid rgba(99,184,255,.12);
    background:rgba(16,55,87,.55);
}

.rag-json-head > span{
    display:grid;
    place-items:center;
    width:39px;
    height:39px;
    border:1px solid rgba(93,192,255,.19);
    border-radius:9px;
    background:rgba(47,153,224,.10);
    color:#5acaff;
    font-weight:900;
}

.rag-json-head small,
.rag-json-head strong{
    display:block;
}

.rag-json-head small{
    color:#5bcaff;
    font-size:8px;
    font-weight:900;
    letter-spacing:.1em;
}

.rag-json-head strong{
    margin-top:4px;
    color:#eaf5fd;
    font-size:12px;
}

.rag-json-card pre{
    flex:1;
    margin:0;
    padding:20px;
    color:#bfe5fa;
    font-family:
        "SFMono-Regular",
        Consolas,
        "Liberation Mono",
        monospace;
    font-size:11px;
    line-height:1.7;
    overflow:auto;
}


/* ==========================================================
   GOVERNANCE
========================================================== */

.rag-governance-layout{
    display:grid;
    grid-template-columns:.8fr 1.2fr;
    gap:17px;
    margin-top:22px;
}

.rag-validation-stack{
    display:grid;
    gap:9px;
}

.rag-validation-stack > div{
    display:grid;
    grid-template-columns:38px 1fr 30px;
    gap:10px;
    align-items:center;
    padding:14px;
    border:1px solid rgba(99,184,255,.13);
    border-radius:11px;
    background:rgba(6,25,43,.64);
}

.rag-validation-stack span{
    display:grid;
    place-items:center;
    width:33px;
    height:33px;
    border-radius:8px;
    background:rgba(56,166,237,.10);
    color:#5bcaff;
    font-size:9px;
    font-weight:900;
}

.rag-validation-stack strong{
    color:#d4e8f5;
    font-size:11px;
}

.rag-validation-stack i{
    display:grid;
    place-items:center;
    width:28px;
    height:28px;
    border-radius:50%;
    background:rgba(50,204,158,.12);
    color:#5ee0b3;
    font-style:normal;
    font-weight:900;
}

.rag-governance-outcomes{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:10px;
}

.rag-governance-outcomes > div{
    min-height:205px;
    padding:17px;
    border:1px solid;
    border-radius:13px;
}

.rag-governance-outcomes small,
.rag-governance-outcomes strong,
.rag-governance-outcomes span{
    display:block;
}

.rag-governance-outcomes small{
    font-size:8px;
    font-weight:900;
    letter-spacing:.1em;
}

.rag-governance-outcomes strong{
    margin-top:12px;
    font-size:13px;
}

.rag-governance-outcomes span{
    margin-top:11px;
    font-size:10px;
    line-height:1.55;
}

.rag-governance-outcomes .approved{
    border-color:rgba(56,218,168,.27);
    background:
        linear-gradient(
            150deg,
            rgba(29,138,105,.12),
            rgba(5,25,42,.85)
        );
}

.rag-governance-outcomes .approved small{
    color:#5bdcb2;
}

.rag-governance-outcomes .approved strong{
    color:#e8fff7;
}

.rag-governance-outcomes .approved span{
    color:#8bb9a9;
}

.rag-governance-outcomes .review{
    border-color:rgba(232,170,68,.28);
    background:
        linear-gradient(
            150deg,
            rgba(180,112,23,.12),
            rgba(5,25,42,.85)
        );
}

.rag-governance-outcomes .review small{
    color:#edb659;
}

.rag-governance-outcomes .review strong{
    color:#fff5e3;
}

.rag-governance-outcomes .review span{
    color:#bba786;
}

.rag-governance-outcomes .blocked{
    border-color:rgba(232,81,81,.28);
    background:
        linear-gradient(
            150deg,
            rgba(166,43,43,.12),
            rgba(5,25,42,.85)
        );
}

.rag-governance-outcomes .blocked small{
    color:#ef7878;
}

.rag-governance-outcomes .blocked strong{
    color:#ffeaea;
}

.rag-governance-outcomes .blocked span{
    color:#b79494;
}

.rag-action-bar{
    display:flex;
    justify-content:space-between;
    gap:18px;
    align-items:center;
    margin-top:15px;
    padding:15px 18px;
    border:1px solid rgba(98,184,255,.13);
    border-radius:12px;
    background:rgba(6,25,43,.58);
}

.rag-action-bar small,
.rag-action-bar strong{
    display:block;
}

.rag-action-bar small{
    color:#5bcaff;
    font-size:8px;
    font-weight:900;
    letter-spacing:.1em;
}

.rag-action-bar strong{
    margin-top:5px;
    color:#dcecf8;
    font-size:11px;
}

.rag-action-bar > div:last-child{
    display:flex;
    flex-wrap:wrap;
    gap:9px;
}

.rag-action-bar .rag-business-button{
    margin-top:0;
}


/* ==========================================================
   MODALS
========================================================== */

.rag-modal{
    width:min(980px,94vw);
    max-height:90vh;
    padding:0;
    border:1px solid rgba(92,187,255,.25);
    border-radius:20px;
    background:#06182b;
    color:#eaf4fc;
    box-shadow:0 35px 110px rgba(0,0,0,.58);
}

.rag-large-modal{
    width:min(1160px,95vw);
}

.rag-code-modal{
    width:min(1080px,95vw);
}

.rag-modal::backdrop{
    background:rgba(1,8,17,.86);
    backdrop-filter:blur(8px);
}

.rag-modal-shell{
    display:flex;
    flex-direction:column;
    max-height:90vh;
}

.rag-modal-header{
    flex:0 0 auto;
    display:flex;
    justify-content:space-between;
    gap:20px;
    align-items:flex-start;
    padding:21px 24px;
    border-bottom:1px solid rgba(99,185,255,.13);
    background:
        linear-gradient(
            135deg,
            rgba(18,61,96,.96),
            rgba(7,28,48,.98)
        );
}

.rag-modal-header small{
    display:block;
    color:#5acaff;
    font-size:9px;
    font-weight:900;
    letter-spacing:.14em;
}

.rag-modal-header h3{
    margin:7px 0 0;
    color:#f2f8ff;
    font-size:22px;
}

.rag-modal-header button{
    flex:0 0 38px;
    width:38px;
    height:38px;
    border:1px solid rgba(106,188,255,.20);
    border-radius:9px;
    background:rgba(255,255,255,.04);
    color:#dceefb;
    font-size:22px;
    cursor:pointer;
}

.rag-modal-content{
    overflow:auto;
    padding:23px;
}

.rag-example-complaint{
    display:flex;
    flex-wrap:wrap;
    gap:12px;
    align-items:center;
    padding:14px 16px;
    border-left:3px solid #56c9ff;
    border-radius:8px;
    background:rgba(43,142,207,.10);
}

.rag-example-complaint span{
    color:#5bcaff;
    font-size:8px;
    font-weight:900;
    letter-spacing:.1em;
}

.rag-example-complaint strong{
    color:#dceef8;
    font-size:12px;
}


/* ==========================================================
   KB MODAL
========================================================== */

.rag-kb-modal-layout{
    display:grid;
    gap:13px;
    margin-top:17px;
}

.rag-kb-parent,
.rag-kb-child{
    padding:18px;
    border:1px solid;
    border-radius:13px;
    background:rgba(6,27,47,.70);
}

.rag-kb-parent{
    border-color:rgba(84,189,255,.38);
}

.rag-kb-child.troubleshooting{
    border-color:rgba(60,216,173,.27);
}

.rag-kb-child.preventive{
    border-color:rgba(151,122,255,.28);
}

.rag-modal-card-label{
    color:#5bcaff;
    font-size:8px;
    font-weight:900;
    letter-spacing:.11em;
}

.rag-kb-parent h4,
.rag-kb-child h4{
    margin:8px 0 13px;
    color:#edf7ff;
}

.rag-kb-parent dl{
    display:grid;
    gap:9px;
    margin:0;
}

.rag-kb-parent dl > div{
    display:grid;
    grid-template-columns:145px 1fr;
    gap:12px;
    padding-bottom:8px;
    border-bottom:1px solid rgba(99,184,255,.08);
}

.rag-kb-parent dt{
    color:#7794aa;
    font-size:10px;
}

.rag-kb-parent dd{
    margin:0;
    color:#d2e5f2;
    font-size:10px;
}

.rag-kb-link-label{
    display:flex;
    align-items:center;
    gap:10px;
}

.rag-kb-link-label span{
    flex:1;
    height:1px;
    background:rgba(84,189,255,.18);
}

.rag-kb-link-label strong{
    color:#5ccaff;
    font-size:8px;
    letter-spacing:.09em;
}

.rag-kb-child-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:11px;
}

.rag-kb-child ul{
    margin:0;
    padding-left:18px;
    color:#afc5d5;
    font-size:10px;
    line-height:1.7;
}

.rag-modal-process{
    display:grid;
    grid-template-columns:1fr auto 1fr auto 1fr;
    gap:10px;
    align-items:center;
    margin-top:17px;
}

.rag-modal-process > div{
    min-height:125px;
    padding:15px;
    border:1px solid rgba(99,184,255,.12);
    border-radius:11px;
    background:rgba(5,23,40,.62);
}

.rag-modal-process span,
.rag-modal-process strong,
.rag-modal-process small{
    display:block;
}

.rag-modal-process span{
    color:#5bcaff;
    font-size:8px;
    font-weight:900;
}

.rag-modal-process strong{
    margin-top:8px;
    color:#e3f1fa;
    font-size:11px;
}

.rag-modal-process small{
    margin-top:6px;
    color:#7792a7;
    font-size:9px;
    line-height:1.5;
}

.rag-modal-process > b{
    color:#58c9ff;
}


/* ==========================================================
   RETRIEVAL MODAL
========================================================== */

.rag-retrieval-modal-grid{
    display:grid;
    grid-template-columns:1.08fr .92fr;
    gap:10px;
    margin-top:17px;
}

.rag-top-five-list{
    display:grid;
    gap:8px;
}

.rag-top-five-list article{
    display:grid;
    grid-template-columns:40px 1fr auto;
    gap:11px;
    align-items:center;
    padding:13px;
    border:1px solid rgba(99,184,255,.11);
    border-radius:10px;
    background:rgba(5,23,40,.60);
}

.rag-top-five-list article.selected{
    border-color:rgba(57,218,168,.34);
    background:rgba(27,139,105,.10);
}

.rag-top-five-list .rank{
    display:grid;
    place-items:center;
    width:35px;
    height:35px;
    border-radius:8px;
    background:rgba(55,165,236,.10);
    color:#5bcaff;
    font-size:9px;
    font-weight:900;
}

.rag-top-five-list small,
.rag-top-five-list strong,
.rag-top-five-list p{
    display:block;
}

.rag-top-five-list small{
    color:#5bcaff;
    font-size:7px;
    font-weight:900;
    letter-spacing:.09em;
}

.rag-top-five-list strong{
    margin-top:4px;
    color:#e2eff8;
    font-size:11px;
}

.rag-top-five-list p{
    margin:4px 0 0;
    color:#7894aa;
    font-size:9px;
}

.rag-top-five-list article > b{
    color:#5cddb3;
    font-size:7px;
    letter-spacing:.09em;
}

.rag-selected-context-card{
    padding:17px;
    border:1px solid rgba(57,215,168,.27);
    border-radius:13px;
    background:
        linear-gradient(
            145deg,
            rgba(26,131,101,.12),
            rgba(5,24,41,.86)
        );
}

.rag-selected-context-header small,
.rag-selected-context-header strong{
    display:block;
}

.rag-selected-context-header small{
    color:#59dcb1;
    font-size:8px;
    font-weight:900;
    letter-spacing:.1em;
}

.rag-selected-context-header strong{
    margin-top:6px;
    color:#edfff8;
    font-size:13px;
}

.rag-selected-context-card article{
    margin-top:10px;
    padding:12px;
    border:1px solid rgba(99,184,255,.10);
    border-radius:9px;
    background:rgba(4,20,35,.54);
}

.rag-selected-context-card article span{
    color:#5bcaff;
    font-size:7px;
    font-weight:900;
    letter-spacing:.1em;
}

.rag-selected-context-card article p{
    margin:6px 0 0;
    color:#b8cedb;
    font-size:10px;
    line-height:1.55;
}

.rag-context-complete{
    display:flex;
    gap:9px;
    align-items:center;
    margin-top:12px;
    padding:12px;
    border-radius:9px;
    background:rgba(47,191,148,.11);
    color:#61ddb5;
}

.rag-context-complete span{
    font-weight:900;
}

.rag-context-complete strong{
    font-size:10px;
}


/* ==========================================================
   CODE MODALS
========================================================== */

.rag-prompt-badges{
    display:flex;
    flex-wrap:wrap;
    gap:8px;
    margin-bottom:13px;
}

.rag-prompt-badges span{
    padding:8px 10px;
    border:1px solid rgba(99,184,255,.13);
    border-radius:999px;
    background:rgba(44,140,204,.08);
    color:#bfe5fa;
    font-size:9px;
    font-weight:800;
}

.rag-code-block{
    margin:0;
    padding:20px;
    overflow:auto;
    border:1px solid rgba(99,184,255,.13);
    border-radius:12px;
    background:#020f1c;
    color:#c4e7fa;
    font-family:
        "SFMono-Regular",
        Consolas,
        "Liberation Mono",
        monospace;
    font-size:11px;
    line-height:1.65;
    white-space:pre-wrap;
}

.rag-adapter-metrics{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:9px;
    margin-bottom:14px;
}

.rag-adapter-metrics > div{
    padding:13px;
    border:1px solid rgba(99,184,255,.12);
    border-radius:10px;
    background:rgba(5,23,40,.62);
}

.rag-adapter-metrics small,
.rag-adapter-metrics strong{
    display:block;
}

.rag-adapter-metrics small{
    color:#7596ac;
    font-size:7px;
    font-weight:900;
    letter-spacing:.1em;
}

.rag-adapter-metrics strong{
    margin-top:6px;
    color:#e2f2fb;
    font-size:9px;
}

.rag-code-note{
    margin:13px 0 0;
    color:#708ca1;
    font-size:9px;
    line-height:1.55;
}


/* ==========================================================
   GOVERNANCE MODAL
========================================================== */

.rag-governance-example-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:11px;
}

.rag-governance-example-grid article{
    padding:17px;
    border:1px solid;
    border-radius:13px;
}

.rag-governance-example-grid article > span{
    font-size:8px;
    font-weight:900;
    letter-spacing:.1em;
}

.rag-governance-example-grid h4{
    margin:9px 0 10px;
    color:#ecf6fd;
    font-size:14px;
}

.rag-governance-example-grid ul{
    margin:0;
    padding-left:18px;
    color:#9eb5c6;
    font-size:10px;
    line-height:1.68;
}

.rag-governance-example-grid .approved{
    border-color:rgba(56,218,168,.27);
    background:rgba(27,139,104,.08);
}

.rag-governance-example-grid .approved > span{
    color:#5bdcb2;
}

.rag-governance-example-grid .review{
    border-color:rgba(233,171,67,.28);
    background:rgba(178,111,22,.08);
}

.rag-governance-example-grid .review > span{
    color:#edb556;
}

.rag-governance-example-grid .blocked{
    border-color:rgba(234,82,82,.28);
    background:rgba(166,42,42,.08);
}

.rag-governance-example-grid .blocked > span{
    color:#ef7676;
}

.rag-governance-summary{
    display:flex;
    flex-wrap:wrap;
    gap:8px;
    align-items:center;
    margin-top:16px;
    padding:14px;
    border-left:3px solid #57c9ff;
    border-radius:8px;
    background:rgba(42,140,204,.09);
}

.rag-governance-summary strong{
    color:#64cbff;
}

.rag-governance-summary span{
    color:#bed5e3;
    font-size:10px;
}


/* ==========================================================
   RESPONSIVE
========================================================== */

@media(max-width:1100px){

    .rag-stage-navigation{
        grid-template-columns:repeat(3,1fr);
    }

    .rag-governance-outcomes{
        grid-template-columns:1fr;
    }

}

@media(max-width:900px){

    .rag-executive-intro,
    .rag-chapter-grid,
    .rag-governance-layout,
    .rag-retrieval-modal-grid{
        grid-template-columns:1fr;
    }

    .rag-executive-visual{
        min-height:310px;
    }

    .rag-policy-strip,
    .rag-child-row,
    .rag-kb-child-grid,
    .rag-governance-example-grid{
        grid-template-columns:1fr;
    }

    .rag-modal-process{
        grid-template-columns:1fr;
    }

    .rag-modal-process > b{
        transform:rotate(90deg);
        text-align:center;
    }

    .rag-adapter-metrics{
        grid-template-columns:1fr 1fr;
    }

}

@media(max-width:680px){

    .rag-stage-header,
    .rag-chapter-heading,
    .rag-selected-result,
    .rag-action-bar{
        align-items:flex-start;
        flex-direction:column;
    }

    .rag-stage-navigation{
        grid-template-columns:1fr 1fr;
    }

    .rag-chapter{
        padding:18px;
    }

    .rag-content-card,
    .rag-system-card{
        min-height:auto;
    }

    .rag-gate-visual{
        grid-template-columns:1fr;
    }

    .rag-routing-example{
        min-height:420px;
    }

    .rag-adapter-metrics,
    .rag-signal-grid{
        grid-template-columns:1fr;
    }

    .rag-signal-grid span:last-child{
        grid-column:auto;
    }

    .rag-top-five-list article{
        grid-template-columns:38px 1fr;
    }

    .rag-top-five-list article > b{
        grid-column:2;
    }

    .rag-kb-parent dl > div{
        grid-template-columns:1fr;
        gap:3px;
    }

}

@media(max-width:480px){

    .rag-stage-navigation{
        grid-template-columns:1fr;
    }

    .rag-core-orbit{
        width:230px;
        height:230px;
    }

}

/* ==========================================================
   LIGHT PRESENTATION CANVAS + ORIGINAL LEFT NAVIGATION
========================================================== */

.smartops-rag-section{
    isolation:isolate;
    background:#f5f9fd;
}

.smartops-rag-section::before{
    inset:0 50%;
    z-index:-2;
    width:100vw;
    height:auto;
    transform:translateX(-50%);
    border-radius:0;
    background:#f5f9fd;
}

.smartops-rag-section::after{
    z-index:-1;
    opacity:.35;
}

.smartops-rag-section .section-heading h2,
.smartops-rag-section .rag-stage-header h3{
    color:#0b1b31;
}

.smartops-rag-section .section-heading p,
.smartops-rag-section .rag-stage-header p{
    color:#6d8298;
}

.smartops-rag-section .rag-stage-header span{
    color:#1769ff;
}

.smartops-rag-section .rag-stage-navigation{
    position:sticky;
    top:92px;
    float:left;
    z-index:4;
    width:292px;
    grid-template-columns:1fr;
    gap:8px;
    margin:17px 24px 24px 0;
    padding:18px;
    border:1px solid rgba(28,91,160,.15);
    border-radius:18px;
    background:linear-gradient(165deg,#0c2744,#071b31);
    box-shadow:0 22px 55px rgba(16,42,70,.18);
}

.smartops-rag-section .rag-stage-navigation::before{
    content:"PIPELINE NAVIGATION";
    display:block;
    padding:2px 3px 10px;
    color:#6bcaff;
    font-size:9px;
    font-weight:900;
    letter-spacing:.14em;
}

.smartops-rag-section .rag-stage-button{
    min-height:0;
    flex-direction:row;
    align-items:center;
    gap:12px;
    padding:13px;
    border-radius:11px;
}

.smartops-rag-section .rag-stage-button:hover{
    transform:translateX(2px);
}

.smartops-rag-section .rag-stage-button .stage-index{
    flex:0 0 36px;
    width:36px;
    height:36px;
}

.smartops-rag-section .rag-stage-button .stage-copy{
    min-width:0;
}

.smartops-rag-section .rag-stage-button .stage-copy small{
    display:none;
}

.smartops-rag-section .rag-stage-button .stage-copy strong{
    margin:0;
    font-size:11px;
}

.smartops-rag-section .rag-stage-button .stage-copy em{
    margin-top:3px;
    font-size:8px;
    line-height:1.35;
}

.smartops-rag-section .rag-main-tabs,
.smartops-rag-section .rag-framework-panel{
    margin-left:316px;
}

.smartops-rag-section .rag-main-tabs{
    padding-top:17px;
}

.smartops-rag-section:has(.tech-tab[data-tab="validation"].active) .rag-stage-navigation{
    display:none;
}

.smartops-rag-section:has(.tech-tab[data-tab="validation"].active) .rag-main-tabs,
.smartops-rag-section:has(.tech-tab[data-tab="validation"].active) .rag-framework-panel{
    margin-left:0;
}

.smartops-rag-section #validationPanel.active{
    clear:both;
}

@media(max-width:1020px){
    .smartops-rag-section .rag-stage-navigation{
        position:static;
        float:none;
        width:auto;
        grid-template-columns:repeat(3,1fr);
        margin-right:0;
    }

    .smartops-rag-section .rag-stage-navigation::before{
        grid-column:1 / -1;
    }

    .smartops-rag-section .rag-main-tabs,
    .smartops-rag-section .rag-framework-panel{
        margin-left:0;
    }
}

@media(max-width:680px){
    .smartops-rag-section .rag-stage-navigation{
        grid-template-columns:1fr;
    }
}

/* Tabs span both columns; navigation and active chapter begin on one row. */
.smartops-rag-section .rag-main-tabs{
    width:100%;
    margin-left:0;
}

/* Light presentation surfaces with the existing blue/cyan accent language. */
.smartops-rag-section .rag-stage-navigation{
    border-color:rgba(30,101,184,.18);
    background:#fff;
    margin-top:19px;
    box-shadow:0 18px 45px rgba(24,67,112,.12);
}

.smartops-rag-section .rag-stage-navigation::before{
    color:#1769ff;
}

.smartops-rag-section .rag-stage-button{
    border-color:rgba(30,101,184,.14);
    background:#f8fbff;
}

.smartops-rag-section .rag-stage-button:hover{
    border-color:rgba(23,105,255,.42);
    background:#f1f7ff;
}

.smartops-rag-section .rag-stage-button.active{
    border-color:rgba(23,105,255,.48);
    background:linear-gradient(135deg,#eef6ff,#f8fcff);
    box-shadow:0 9px 24px rgba(23,105,255,.10);
}

.smartops-rag-section .rag-stage-button .stage-index{
    border-color:rgba(23,105,255,.22);
    background:#eaf3ff;
    color:#1769ff;
}

.smartops-rag-section .rag-stage-button.active .stage-index{
    border-color:#1769ff;
    background:#1769ff;
    color:#fff;
}

.smartops-rag-section .rag-stage-button .stage-copy strong,
.smartops-rag-section .rag-stage-button.active .stage-copy strong{
    color:#12263d;
}

.smartops-rag-section .rag-stage-button .stage-copy em,
.smartops-rag-section .rag-stage-button.active .stage-copy em{
    color:#71869a;
}

.smartops-rag-section .rag-chapter{
    border-color:rgba(30,101,184,.16);
    background:#fff;
    box-shadow:0 22px 55px rgba(24,67,112,.12);
}

.smartops-rag-section .rag-chapter-heading{
    border-bottom-color:rgba(30,101,184,.13);
}

.smartops-rag-section .rag-chapter-heading h3,
.smartops-rag-section .rag-chapter h4,
.smartops-rag-section .rag-chapter strong{
    color:#10233a;
}

.smartops-rag-section .rag-chapter-heading p,
.smartops-rag-section .rag-chapter p,
.smartops-rag-section .rag-chapter small,
.smartops-rag-section .rag-chapter em{
    color:#6f8498;
}

.smartops-rag-section .rag-chapter [class*="card"],
.smartops-rag-section .rag-information-list > div,
.smartops-rag-section .rag-feature-stack > div,
.smartops-rag-section .rag-prompt-rules > div,
.smartops-rag-section .rag-validation-stack > div,
.smartops-rag-section .rag-retrieval-node,
.smartops-rag-section .rag-parallel-search,
.smartops-rag-section .rag-routing-message,
.smartops-rag-section .rag-model-block,
.smartops-rag-section .rag-category-output span,
.smartops-rag-section .rag-policy-strip > div,
.smartops-rag-section .rag-governance-outcomes > div{
    border-color:rgba(30,101,184,.14);
    background:#f7faff;
    box-shadow:none;
}

.smartops-rag-section .rag-system-card{
    border-color:rgba(30,101,184,.14);
    background:#f7faff;
}

.smartops-rag-section .rag-routing-message p,
.smartops-rag-section .rag-model-block strong,
.smartops-rag-section .rag-category-output span{
    color:#18314c;
}

.smartops-rag-section .rag-chapter-code,
.smartops-rag-section .rag-card-label{
    color:#0879cf;
}

/* ==========================================================
   BUSINESS-PITCH VISUAL POLISH
========================================================== */

.smartops-rag-section{
    --rag-ink:#102a43;
    --rag-muted:#627d98;
    --rag-blue:#1769ff;
    --rag-cyan:#0798d7;
    --rag-teal:#0aa67f;
    --rag-amber:#d88a16;
    --rag-red:#d64c5d;
    --rag-line:#d7e5f2;
    --rag-soft:#f6faff;
    --rag-mint:#eefbf7;
    --rag-lilac:#f7f3ff;
}

.smartops-rag-section .rag-main-tabs{
    padding:7px;
    border:1px solid #d5e3f0;
    border-radius:14px;
    background:#fff;
    box-shadow:0 12px 30px rgba(25,72,119,.09);
}

.smartops-rag-section .rag-main-tabs .tech-tab{
    color:#5d7389;
}

.smartops-rag-section .rag-main-tabs .tech-tab.active{
    background:linear-gradient(135deg,#1769ff,#0798d7);
    color:#fff;
    box-shadow:0 7px 18px rgba(23,105,255,.24);
}

.smartops-rag-section .rag-stage-navigation{
    border-top:4px solid var(--rag-blue);
}

/* Grouped pipeline navigation with focused subchapters. */
.smartops-rag-section .rag-stage-navigation{
    gap:11px;
    background:
        linear-gradient(rgba(23,105,255,.045) 1px,transparent 1px),
        linear-gradient(90deg,rgba(23,105,255,.045) 1px,transparent 1px),
        #f8fbff;
    background-size:28px 28px,28px 28px,auto;
}

.smartops-rag-section .rag-nav-group{
    display:grid;
    min-width:0;
}

.smartops-rag-section .rag-stage-button{
    width:100%;
    border-color:#d3e1ed;
    border-radius:14px;
    background:rgba(255,255,255,.94);
}

.smartops-rag-section .rag-stage-button.active{
    border-color:#2e8df0;
    background:linear-gradient(135deg,#092748,#104e85 72%,#0b345d);
    box-shadow:0 10px 24px rgba(18,78,137,.22),inset 0 1px rgba(255,255,255,.1);
}

.smartops-rag-section .rag-stage-button.active .stage-copy strong{
    color:#fff;
}

.smartops-rag-section .rag-stage-button.active .stage-copy em{
    color:#b8d1e7;
}

.smartops-rag-section .rag-stage-button.active .stage-index{
    border-color:#499fff;
    background:linear-gradient(145deg,#2f82f6,#1769e7);
    color:#fff;
    box-shadow:0 0 0 7px rgba(52,139,255,.12);
}

.smartops-rag-section .rag-stage-parent{
    padding-right:44px;
}

.smartops-rag-section .stage-chevron{
    position:absolute;
    right:17px;
    top:50%;
    width:9px;
    height:9px;
    border-right:2px solid #7990a6;
    border-bottom:2px solid #7990a6;
    transform:translateY(-65%) rotate(45deg);
    transition:transform .22s ease,border-color .22s ease;
}

.smartops-rag-section .rag-stage-parent.active .stage-chevron{
    border-color:#d9ebfa;
}

.smartops-rag-section .rag-nav-group.expanded .stage-chevron{
    transform:translateY(-25%) rotate(225deg);
}

.smartops-rag-section .rag-subnav{
    position:relative;
    display:grid;
    gap:8px;
    max-height:0;
    margin:0;
    padding:0 0 0 30px;
    overflow:hidden;
    opacity:0;
    transition:max-height .28s ease,opacity .2s ease,padding .28s ease;
}

.smartops-rag-section .rag-nav-group.expanded .rag-subnav{
    max-height:360px;
    padding-top:12px;
    padding-bottom:2px;
    opacity:1;
}

.smartops-rag-section .rag-subnav::before{
    content:"";
    position:absolute;
    top:0;
    bottom:10px;
    left:14px;
    width:1px;
    background:#91c5f3;
}

.smartops-rag-section .rag-subnav-button{
    position:relative;
    display:grid;
    grid-template-columns:42px minmax(0,1fr);
    align-items:center;
    gap:11px;
    min-height:66px;
    padding:10px 11px;
    border:1px solid #d3e1ed;
    border-radius:14px;
    background:rgba(255,255,255,.96);
    color:#17324e;
    text-align:left;
    cursor:pointer;
    transition:border-color .18s ease,background .18s ease,transform .18s ease;
}

.smartops-rag-section .rag-subnav-button::before{
    content:"";
    position:absolute;
    top:50%;
    left:-16px;
    width:15px;
    height:1px;
    background:#91c5f3;
}

.smartops-rag-section .rag-subnav-button:hover{
    transform:translateX(2px);
    border-color:#8bbcf2;
    background:#f4f9ff;
}

.smartops-rag-section .rag-subnav-button > span:first-child{
    display:grid;
    place-items:center;
    width:42px;
    height:42px;
    border-radius:12px;
    background:#edf3fa;
    color:#5e7891;
    font-size:12px;
    font-weight:900;
}

.smartops-rag-section .rag-subnav-button strong,
.smartops-rag-section .rag-subnav-button em{
    display:block;
}

.smartops-rag-section .rag-subnav-button strong{
    color:#18324d;
    font-size:11px;
    line-height:1.25;
}

.smartops-rag-section .rag-subnav-button em{
    margin-top:4px;
    color:#7e92a6;
    font-size:8px;
    font-style:normal;
    line-height:1.3;
}

.smartops-rag-section .rag-subnav-button.active{
    border-color:#62a7f4;
    background:#eef6ff;
    box-shadow:0 7px 18px rgba(23,105,255,.09);
}

.smartops-rag-section .rag-subnav-button.active > span:first-child{
    background:#2e73f2;
    color:#fff;
}

.smartops-rag-section .rag-subchapter-heading{
    margin-top:26px;
    padding-top:24px;
    border-top:1px solid rgba(30,101,184,.13);
}

.smartops-rag-section #knowledge-preparation-section,
.smartops-rag-section #parent-child-section,
.smartops-rag-section #hybrid-retrieval-section,
.smartops-rag-section #classification-model-section,
.smartops-rag-section #routing-category-section{
    scroll-margin-top:112px;
}

.smartops-rag-section .rag-chapter{
    position:relative;
    border-top:4px solid var(--rag-blue);
    overflow:hidden;
}

.smartops-rag-section .rag-chapter::before{
    content:"";
    position:absolute;
    top:0;
    right:0;
    width:260px;
    height:160px;
    background:radial-gradient(circle at top right,rgba(23,105,255,.08),transparent 68%);
    pointer-events:none;
}

.smartops-rag-section .rag-chapter-heading,
.smartops-rag-section .rag-chapter-grid,
.smartops-rag-section .rag-retrieval-board,
.smartops-rag-section .rag-selected-result,
.smartops-rag-section .rag-governance-layout,
.smartops-rag-section .rag-action-bar{
    position:relative;
    z-index:1;
}

.smartops-rag-section .rag-chapter-status{
    border-color:#bceade;
    background:#ecfaf6;
    color:#087e61;
}

.smartops-rag-section .rag-content-card,
.smartops-rag-section .rag-system-card{
    border-color:#d4e4f2;
    background:linear-gradient(160deg,#fff,#f6faff);
}

.smartops-rag-section .rag-content-card{
    border-top:3px solid var(--rag-blue);
}

.smartops-rag-section .rag-system-card{
    border-top:3px solid var(--rag-teal);
}

/* Chapter 02: knowledge preparation flow */
.smartops-rag-section .rag-kb-preparation{
    position:relative;
    z-index:1;
    margin-top:22px;
    padding:46px 22px 22px;
    overflow:hidden;
    border:1px solid rgba(77,161,232,.38);
    border-radius:18px;
    background:
        linear-gradient(rgba(72,154,221,.08) 1px,transparent 1px),
        linear-gradient(90deg,rgba(72,154,221,.08) 1px,transparent 1px),
        radial-gradient(circle at 52% 18%,rgba(27,111,205,.25),transparent 42%),
        linear-gradient(135deg,#071d35,#0b3158 52%,#071d35);
    background-size:34px 34px,34px 34px,auto,auto;
    box-shadow:0 18px 42px rgba(17,57,96,.18);
}

.smartops-rag-section .rag-kb-preparation-label{
    position:absolute;
    top:18px;
    right:22px;
    color:#7aa6ca;
    font-size:9px;
    font-weight:900;
    letter-spacing:.22em;
}

.smartops-rag-section .rag-kb-preparation-track{
    display:grid;
    grid-template-columns:repeat(5,minmax(0,1fr));
    gap:38px;
}

.smartops-rag-section .rag-kb-preparation-step{
    position:relative;
    min-height:214px;
    padding:22px 18px;
    border:1px solid rgba(118,183,235,.32);
    border-radius:18px;
    background:linear-gradient(155deg,rgba(47,86,122,.94),rgba(25,58,91,.96));
    box-shadow:inset 0 1px rgba(255,255,255,.06);
}

.smartops-rag-section .rag-kb-preparation-step:not(:last-child)::after{
    content:"\2192";
    position:absolute;
    top:50%;
    right:-30px;
    transform:translateY(-50%);
    color:#61b9ff;
    font-size:30px;
    font-weight:500;
    line-height:1;
}

.smartops-rag-section .rag-kb-preparation-step .step-number{
    display:grid;
    place-items:center;
    width:52px;
    height:52px;
    border:1px solid rgba(58,164,249,.56);
    border-radius:14px;
    background:rgba(20,91,151,.38);
    color:#b8dcff;
    font-size:15px;
    font-weight:900;
    letter-spacing:.08em;
}

.smartops-rag-section .rag-kb-preparation-step h4{
    margin:20px 0 12px;
    color:#f5f9ff;
    font-size:19px;
    line-height:1.15;
    letter-spacing:-.01em;
}

.smartops-rag-section .rag-kb-preparation-step p{
    margin:0;
    color:#a8bfd2;
    font-size:12px;
    line-height:1.5;
}

@media(max-width:1050px){
    .smartops-rag-section .rag-kb-preparation{
        padding-right:16px;
        padding-left:16px;
    }

    .smartops-rag-section .rag-kb-preparation-track{
        gap:30px;
    }

    .smartops-rag-section .rag-kb-preparation-step{
        padding:18px 14px;
    }

    .smartops-rag-section .rag-kb-preparation-step:not(:last-child)::after{
        right:-25px;
    }
}

@media(max-width:680px){
    .smartops-rag-section .rag-kb-preparation{
        padding:52px 18px 20px;
    }

    .smartops-rag-section .rag-kb-preparation-label{
        right:auto;
        left:18px;
    }

    .smartops-rag-section .rag-kb-preparation-track{
        grid-template-columns:1fr;
        gap:34px;
    }

    .smartops-rag-section .rag-kb-preparation-step{
        min-height:auto;
    }

    .smartops-rag-section .rag-kb-preparation-step:not(:last-child)::after{
        top:auto;
        right:50%;
        bottom:-29px;
        transform:translateX(50%) rotate(90deg);
        font-size:25px;
    }
}

.smartops-rag-section .rag-information-list > div,
.smartops-rag-section .rag-feature-stack > div,
.smartops-rag-section .rag-prompt-rules > div,
.smartops-rag-section .rag-signal-grid span{
    border-color:#d8e7f4;
    background:#fff;
}

.smartops-rag-section .rag-information-list > div > span,
.smartops-rag-section .rag-feature-stack i,
.smartops-rag-section .rag-prompt-rules span{
    border-color:#c7dfff;
    background:#eaf4ff;
    color:var(--rag-blue);
}

.smartops-rag-section .rag-information-list strong,
.smartops-rag-section .rag-feature-stack strong,
.smartops-rag-section .rag-prompt-rules strong,
.smartops-rag-section .rag-signal-grid span{
    color:var(--rag-ink);
}

/* Knowledge-base architecture: one decisive parent, two linked evidence roles. */
.smartops-rag-section .rag-parent-child-architecture{
    gap:16px;
}

.smartops-rag-section .rag-parent-card{
    position:relative;
    padding:22px;
    border:0;
    border-radius:15px;
    background:linear-gradient(135deg,#123b70,#1769ff);
    box-shadow:0 16px 34px rgba(23,105,255,.22);
    overflow:hidden;
}

.smartops-rag-section .rag-parent-card::after{
    content:"P";
    position:absolute;
    right:18px;
    top:50%;
    transform:translateY(-50%);
    color:rgba(255,255,255,.10);
    font-size:68px;
    font-weight:900;
}

.smartops-rag-section .rag-parent-card small,
.smartops-rag-section .rag-parent-card strong,
.smartops-rag-section .rag-parent-card span{
    position:relative;
    z-index:1;
    color:#fff;
}

.smartops-rag-section .rag-parent-card small{
    color:#9ce8ff;
}

.smartops-rag-section .rag-parent-card span{
    color:#d9eaff;
}

.smartops-rag-section .rag-link-line span{
    background:#bad8f3;
}

.smartops-rag-section .rag-link-line b{
    padding:5px 10px;
    border:1px solid #c5dff5;
    border-radius:999px;
    background:#fff;
    color:#0879cf;
}

.smartops-rag-section .rag-child-card{
    padding:19px;
    box-shadow:0 9px 22px rgba(26,72,115,.07);
}

.smartops-rag-section .rag-child-card.troubleshooting{
    border-color:#a9e4d4;
    background:linear-gradient(145deg,#fff,#ecfaf6);
}

.smartops-rag-section .rag-child-card.preventive{
    border-color:#d9cbf7;
    background:linear-gradient(145deg,#fff,#f6f1ff);
}

.smartops-rag-section .rag-child-card.troubleshooting small{
    color:#078568;
}

.smartops-rag-section .rag-child-card.preventive small{
    color:#7652c8;
}

.smartops-rag-section .rag-child-card strong{
    color:var(--rag-ink);
}

.smartops-rag-section .rag-child-card span{
    color:var(--rag-muted);
}

.smartops-rag-section .rag-indexing-rule{
    display:grid;
    grid-template-columns:auto 1fr auto auto 1fr auto auto 1fr;
    justify-content:stretch;
    gap:8px;
    padding:14px;
    border:1px solid #cfe1f2;
    border-radius:13px;
    background:linear-gradient(90deg,#eef6ff,#f2fbf8);
}

.smartops-rag-section .rag-indexing-rule span{
    width:29px;
    height:29px;
    border-radius:50%;
    background:var(--rag-blue);
    color:#fff;
}

.smartops-rag-section .rag-indexing-rule strong{
    align-self:center;
    color:var(--rag-ink);
    font-size:9px;
}

.smartops-rag-section .rag-indexing-rule b{
    align-self:center;
    color:var(--rag-cyan);
}

/* Retrieval and governance boards remain visual, but readable on white. */
.smartops-rag-section .rag-retrieval-board,
.smartops-rag-section .rag-gate-visual,
.smartops-rag-section .rag-action-bar,
.smartops-rag-section .rag-selected-result{
    border-color:#d5e5f2;
    background:linear-gradient(145deg,#f7fbff,#eef7ff);
}

/* Keep the live retrieval sequence on one presentation row. */
.smartops-rag-section .rag-retrieval-board{
    flex-wrap:nowrap;
    gap:6px;
    padding:18px 14px;
}

.smartops-rag-section .rag-retrieval-node,
.smartops-rag-section .rag-parallel-search{
    flex:1 1 0;
    min-width:0;
}

.smartops-rag-section .rag-retrieval-node,
.smartops-rag-section .rag-parallel-search > div{
    min-width:0;
    padding:15px 8px;
}

.smartops-rag-section .rag-flow-arrow{
    flex:0 0 auto;
}

@media(max-width:680px){
    .smartops-rag-section .rag-retrieval-board{
        flex-wrap:wrap;
    }

    .smartops-rag-section .rag-retrieval-node,
    .smartops-rag-section .rag-parallel-search{
        flex:1 1 140px;
    }

    .smartops-rag-section .rag-flow-arrow{
        display:none;
    }
}

.smartops-rag-section .rag-retrieval-node,
.smartops-rag-section .rag-parallel-search > div{
    border-color:#cee1f2;
    background:#fff;
    box-shadow:0 8px 20px rgba(29,76,121,.07);
}

.smartops-rag-section .rag-retrieval-node strong,
.smartops-rag-section .rag-parallel-search strong,
.smartops-rag-section .rag-selected-result strong,
.smartops-rag-section .rag-action-bar strong{
    color:var(--rag-ink);
}

.smartops-rag-section .rag-retrieval-node span,
.smartops-rag-section .rag-parallel-search span,
.smartops-rag-section .rag-selected-result span{
    color:var(--rag-muted);
}

.smartops-rag-section .rag-gate-outcomes > div,
.smartops-rag-section .rag-governance-outcomes > div,
.smartops-rag-section .rag-validation-stack > div{
    background:#fff;
    box-shadow:0 8px 20px rgba(29,76,121,.06);
}

.smartops-rag-section .rag-json-card{
    border-color:#cfe0ef;
    background:#f7fbff;
}

.smartops-rag-section .rag-json-head{
    border-bottom-color:#d7e6f2;
}

.smartops-rag-section .rag-json-head strong,
.smartops-rag-section .rag-json-card pre{
    color:#17324d;
}

/* Every example dialog uses a bright presentation surface. */
.smartops-rag-section .rag-modal{
    border-color:#c9dceb;
    background:#fff;
    color:var(--rag-ink);
    box-shadow:0 35px 100px rgba(15,42,70,.28);
}

.smartops-rag-section .rag-modal::backdrop{
    background:rgba(10,28,47,.58);
}

.smartops-rag-section .rag-modal-header{
    border-bottom-color:#d7e5f1;
    background:linear-gradient(135deg,#f7fbff,#edf6ff);
}

.smartops-rag-section .rag-modal-header small{
    color:var(--rag-blue);
}

.smartops-rag-section .rag-modal-header h3{
    color:var(--rag-ink);
}

.smartops-rag-section .rag-modal-header button{
    border-color:#cbdceb;
    background:#fff;
    color:#24445f;
    box-shadow:0 6px 14px rgba(24,67,112,.08);
}

.smartops-rag-section .rag-modal-content{
    background:#fff;
}

.smartops-rag-section .rag-example-complaint{
    border-left-color:var(--rag-blue);
    background:#eef6ff;
}

.smartops-rag-section .rag-example-complaint span{
    color:var(--rag-blue);
}

.smartops-rag-section .rag-example-complaint strong{
    color:var(--rag-ink);
}

.smartops-rag-section .rag-kb-parent,
.smartops-rag-section .rag-kb-child,
.smartops-rag-section .rag-modal-process > div,
.smartops-rag-section .rag-top-five-list article,
.smartops-rag-section .rag-selected-context-card,
.smartops-rag-section .rag-selected-context-card article,
.smartops-rag-section .rag-adapter-metrics > div{
    border-color:#d3e3f1;
    background:#f8fbff;
}

.smartops-rag-section .rag-kb-parent{
    border-left:4px solid var(--rag-blue);
}

.smartops-rag-section .rag-kb-child.troubleshooting{
    border-left:4px solid var(--rag-teal);
    background:var(--rag-mint);
}

.smartops-rag-section .rag-kb-child.preventive{
    border-left:4px solid #805ad5;
    background:var(--rag-lilac);
}

.smartops-rag-section .rag-kb-parent h4,
.smartops-rag-section .rag-kb-child h4,
.smartops-rag-section .rag-kb-parent dd,
.smartops-rag-section .rag-modal-process strong,
.smartops-rag-section .rag-top-five-list strong,
.smartops-rag-section .rag-selected-context-header strong,
.smartops-rag-section .rag-selected-context-card article p,
.smartops-rag-section .rag-adapter-metrics strong{
    color:var(--rag-ink);
}

.smartops-rag-section .rag-kb-parent dt,
.smartops-rag-section .rag-kb-child ul,
.smartops-rag-section .rag-modal-process small,
.smartops-rag-section .rag-top-five-list p,
.smartops-rag-section .rag-code-note{
    color:var(--rag-muted);
}

.smartops-rag-section .rag-top-five-list article.selected{
    border:2px solid #49b89a;
    background:#effbf7;
    box-shadow:0 9px 22px rgba(10,166,127,.12);
}

.smartops-rag-section .rag-selected-context-card{
    border:1px solid #a9dfd1;
    background:linear-gradient(145deg,#fff,#effbf7);
}

.smartops-rag-section .rag-selected-context-card article{
    background:#fff;
}

.smartops-rag-section .rag-context-complete{
    background:#e7f8f2;
    color:#087e61;
}

.smartops-rag-section .rag-prompt-badges span{
    border-color:#cfe0ef;
    background:#eef6ff;
    color:#24577d;
}

.smartops-rag-section .rag-code-block{
    border-color:#cddfeb;
    background:#f6f9fc;
    color:#183b56;
    box-shadow:inset 4px 0 #1769ff;
}

.smartops-rag-section .rag-governance-example-grid h4{
    color:var(--rag-ink);
}

.smartops-rag-section .rag-governance-example-grid ul{
    color:var(--rag-muted);
}

.smartops-rag-section .rag-governance-example-grid .approved{
    border-color:#a9dfd1;
    background:#effbf7;
}

.smartops-rag-section .rag-governance-example-grid .review{
    border-color:#f0d19a;
    background:#fff8ea;
}

.smartops-rag-section .rag-governance-example-grid .blocked{
    border-color:#efbdc4;
    background:#fff3f5;
}

.smartops-rag-section .rag-governance-summary{
    border-left-color:var(--rag-blue);
    background:#eef6ff;
}

.smartops-rag-section .rag-governance-summary strong{
    color:var(--rag-blue);
}

.smartops-rag-section .rag-governance-summary span{
    color:#365d7d;
}

@media(max-width:760px){
    .smartops-rag-section .rag-indexing-rule{
        grid-template-columns:auto 1fr;
    }

    .smartops-rag-section .rag-indexing-rule b{
        display:none;
    }
}

/* Preserve the original Chapter 01A / 01B presentation artwork. */
.smartops-rag-section .rag-chapter.intake-chapter{
    margin-top:19px;
    padding:0;
    border:0;
    border-radius:0;
    background:transparent;
    box-shadow:none;
    overflow:visible;
}

.smartops-rag-section .rag-chapter.intake-chapter::before{
    display:none;
}

.smartops-rag-section .intake-chapter .classifier-architecture .node-copy strong,
.smartops-rag-section .intake-chapter .classifier-architecture .data-format span,
.smartops-rag-section .intake-chapter .classifier-architecture .tech-tags span,
.smartops-rag-section .intake-chapter .routing-system-core .router-core-copy strong,
.smartops-rag-section .intake-chapter .routing-system-core .router-domain-count span{
    color:#fff;
}

.smartops-rag-section .intake-chapter .classifier-architecture .node-copy p,
.smartops-rag-section .intake-chapter .classifier-architecture .data-format small,
.smartops-rag-section .intake-chapter .classifier-architecture .node-topline small,
.smartops-rag-section .intake-chapter .routing-system-core .router-core-copy small,
.smartops-rag-section .intake-chapter .routing-system-core .router-domain-count small{
    color:#b8cce0;
}

.smartops-rag-section .intake-chapter .tech-category-card{
    background:#fff;
}

/* Indexed parent uses the same boxed grammar as both linked children. */
.smartops-rag-section .rag-chapter .rag-parent-card{
    position:relative;
    padding:20px;
    border:2px solid #82b7ff;
    border-left:5px solid var(--rag-blue);
    border-radius:14px;
    background:linear-gradient(145deg,#fff,#edf6ff);
    box-shadow:0 10px 24px rgba(23,105,255,.11);
    overflow:visible;
}

.smartops-rag-section .rag-chapter .rag-parent-card::after{
    display:none;
}

.smartops-rag-section .rag-chapter .rag-parent-card small{
    color:#0879cf;
}

.smartops-rag-section .rag-chapter .rag-parent-card strong{
    color:var(--rag-ink);
}

.smartops-rag-section .rag-chapter .rag-parent-card span{
    color:var(--rag-muted);
}

/* Gate 1: four real readiness inputs, one calibrated decision. */
.smartops-rag-section .rag-gate1-chapter .rag-chapter-grid{
    grid-template-columns:.82fr 1.18fr;
    align-items:stretch;
}

.smartops-rag-section .rag-gate1-chapter .rag-content-card,
.smartops-rag-section .rag-gate1-chapter .rag-system-card{
    min-height:0;
}

.smartops-rag-section .rag-gate1-chapter .rag-signal-grid{
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:12px;
}

.smartops-rag-section .rag-gate1-chapter .rag-signal-grid span,
.smartops-rag-section .rag-gate1-chapter .rag-signal-grid span:last-child{
    grid-column:auto;
    min-height:105px;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    padding:17px;
    border:1px solid #cfe0ef;
    border-top:3px solid var(--rag-blue);
    border-radius:13px;
    background:linear-gradient(150deg,#fff,#f2f8ff);
    box-shadow:0 8px 20px rgba(24,67,112,.07);
}

.smartops-rag-section .rag-gate1-chapter .rag-signal-grid span:nth-child(2){
    border-top-color:var(--rag-cyan);
}

.smartops-rag-section .rag-gate1-chapter .rag-signal-grid span:nth-child(3){
    border-top-color:var(--rag-teal);
    background:linear-gradient(150deg,#fff,#effbf7);
}

.smartops-rag-section .rag-gate1-chapter .rag-signal-grid span:nth-child(4){
    border-top-color:#7652c8;
    background:linear-gradient(150deg,#fff,#f7f3ff);
}

.smartops-rag-section .rag-gate1-chapter .rag-signal-grid small{
    color:#5f7890;
    font-size:9px;
    font-weight:900;
    letter-spacing:.08em;
    text-transform:uppercase;
}

.smartops-rag-section .rag-gate1-chapter .rag-signal-grid strong{
    margin-top:10px;
    color:var(--rag-ink);
    font-size:23px;
    line-height:1;
}

.smartops-rag-section .rag-gate-flow{
    display:grid;
    justify-items:center;
    gap:5px;
    margin-bottom:15px;
}

.smartops-rag-section .rag-gate-flow > div{
    width:100%;
    padding:11px 14px;
    border:1px solid #d4e4f1;
    border-radius:10px;
    background:#fff;
    text-align:center;
}

.smartops-rag-section .rag-gate-flow > div:nth-of-type(2){
    border-color:#bfe2ee;
    background:#effaff;
}

.smartops-rag-section .rag-gate-flow > div:nth-of-type(3){
    border-color:#b7e3d7;
    background:#effbf7;
}

.smartops-rag-section .rag-gate-flow small,
.smartops-rag-section .rag-gate-flow strong{
    display:block;
}

.smartops-rag-section .rag-gate-flow small{
    color:#0879cf;
    font-size:7px;
    font-weight:900;
    letter-spacing:.12em;
}

.smartops-rag-section .rag-gate-flow strong{
    margin-top:3px;
    color:var(--rag-ink);
    font-size:10px;
}

.smartops-rag-section .rag-gate-flow > b{
    color:#0798d7;
    font-size:16px;
    line-height:1;
}

.smartops-rag-section .rag-gate1-chapter .rag-gate-visual{
    height:auto;
    padding:16px;
    border:1px solid #d5e5f2;
    border-radius:15px;
    background:linear-gradient(145deg,#f8fbff,#eef7ff);
}

.smartops-rag-section .rag-gate1-chapter .rag-gauge{
    width:190px;
    height:190px;
    background:radial-gradient(circle,#fff 0 49%,transparent 50%);
    filter:drop-shadow(0 10px 18px rgba(28,77,123,.10));
}

.smartops-rag-section .rag-gate1-chapter .gauge-needle{
    width:64px;
    background:#173b59;
    box-shadow:0 0 0 4px rgba(23,59,89,.08);
}

.smartops-rag-section .rag-gate1-chapter .rag-gauge small{
    color:#0879cf;
}

.smartops-rag-section .rag-gate1-chapter .rag-gauge strong{
    color:var(--rag-ink);
    font-size:34px;
}

.smartops-rag-section .rag-gate1-chapter .rag-gate-outcomes > div{
    min-height:62px;
}

.smartops-rag-section .rag-gate-footer{
    margin-top:16px;
    padding:15px 18px;
    border-left:4px solid var(--rag-blue);
    border-radius:10px;
    background:#edf6ff;
    color:#365d7d;
    font-size:11px;
    font-weight:750;
    line-height:1.55;
}

@media(max-width:900px){
    .smartops-rag-section .rag-gate1-chapter .rag-chapter-grid{
        grid-template-columns:1fr;
    }
}

@media(max-width:520px){
    .smartops-rag-section .rag-gate1-chapter .rag-signal-grid{
        grid-template-columns:1fr;
    }
}

/* Simplified Gate 1 pitch slide. */
.smartops-rag-section .rag-gate-simple{
    display:grid;
    grid-template-columns:1.12fr .88fr;
    gap:30px;
    align-items:stretch;
}

.smartops-rag-section .rag-gate-simple-copy{
    padding:18px 8px 12px;
}

.smartops-rag-section .rag-gate-simple-copy h3{
    max-width:680px;
    margin:15px 0 14px;
    color:var(--rag-ink);
    font-size:clamp(30px,3.2vw,48px);
    line-height:1.08;
    letter-spacing:-.035em;
}

.smartops-rag-section .rag-gate-simple-copy > p:not(.rag-gate-simple-note){
    max-width:650px;
    margin:0;
    color:var(--rag-muted);
    font-size:13px;
    line-height:1.75;
}

.smartops-rag-section .rag-gate-simple-outcomes{
    display:grid;
    gap:8px;
    margin-top:23px;
}

.smartops-rag-section .rag-gate-simple-outcomes > div{
    display:flex;
    flex-wrap:wrap;
    gap:6px 10px;
    align-items:center;
    padding:11px 14px;
    border-radius:9px;
}

.smartops-rag-section .rag-gate-simple-outcomes strong{
    font-size:9px;
    letter-spacing:.04em;
}

.smartops-rag-section .rag-gate-simple-outcomes span{
    font-size:9px;
    font-weight:700;
}

.smartops-rag-section .rag-gate-simple-outcomes .ready{
    background:#e5f8f1;
    color:#087e61;
}

.smartops-rag-section .rag-gate-simple-outcomes .review{
    background:#fff3df;
    color:#a4660c;
}

.smartops-rag-section .rag-gate-simple-outcomes .blocked{
    background:#fdecef;
    color:#bd3448;
}

.smartops-rag-section .rag-gate-simple-copy .rag-business-button{
    margin-top:19px;
    border-color:#bcd5eb;
    background:#fff;
    color:#244b6b;
    box-shadow:0 8px 18px rgba(24,67,112,.08);
}

.smartops-rag-section .rag-gate-simple-note{
    margin:15px 0 0;
    color:#7890a5;
    font-size:9px;
    line-height:1.55;
}

.smartops-rag-section .rag-gate-simple-visual{
    display:grid;
    grid-template-columns:1fr 125px;
    gap:18px;
    align-items:center;
    min-height:420px;
    padding:28px;
    border:1px solid #cfe0ef;
    border-radius:18px;
    background-color:#f8fbff;
    background-image:
        linear-gradient(rgba(23,105,255,.055) 1px,transparent 1px),
        linear-gradient(90deg,rgba(23,105,255,.055) 1px,transparent 1px);
    background-size:25px 25px;
}

.smartops-rag-section .rag-gate-simple-visual .rag-gauge{
    width:210px;
    height:210px;
}

.smartops-rag-section .rag-gate-simple-labels{
    display:grid;
    gap:12px;
}

.smartops-rag-section .rag-gate-simple-labels span{
    min-height:58px;
    display:grid;
    place-items:center;
    padding:10px;
    border-radius:11px;
    font-size:8px;
    font-weight:900;
    text-align:center;
}

.smartops-rag-section .rag-gate-simple-labels .ready{
    background:#e2f7f0;
    color:#087e61;
}

.smartops-rag-section .rag-gate-simple-labels .review{
    background:#fff2dc;
    color:#a4660c;
}

.smartops-rag-section .rag-gate-simple-labels .blocked{
    background:#fde9ed;
    color:#bd3448;
}

/* Gate 1 Learn More modal. */
.smartops-rag-section .rag-gate-detail-grid{
    display:grid;
    grid-template-columns:.95fr 1.05fr;
    gap:18px;
}

.smartops-rag-section .rag-gate-components,
.smartops-rag-section .rag-gate-output-example{
    padding:20px;
    border:1px solid #d3e3f1;
    border-radius:15px;
    background:#f8fbff;
}

.smartops-rag-section .rag-gate-components h4,
.smartops-rag-section .rag-gate-output-example h4{
    margin:8px 0 16px;
    color:var(--rag-ink);
    font-size:17px;
}

.smartops-rag-section .rag-gate-component-list{
    display:grid;
    gap:9px;
}

.smartops-rag-section .rag-gate-component-list article{
    display:grid;
    grid-template-columns:34px 1fr;
    gap:11px;
    padding:13px;
    border:1px solid #d6e5f1;
    border-radius:11px;
    background:#fff;
}

.smartops-rag-section .rag-gate-component-list article > span{
    width:32px;
    height:32px;
    display:grid;
    place-items:center;
    border-radius:8px;
    background:#eaf4ff;
    color:var(--rag-blue);
    font-size:8px;
    font-weight:900;
}

.smartops-rag-section .rag-gate-component-list strong{
    color:var(--rag-ink);
    font-size:10px;
}

.smartops-rag-section .rag-gate-component-list p{
    margin:4px 0 0;
    color:var(--rag-muted);
    font-size:9px;
    line-height:1.5;
}

.smartops-rag-section .rag-gate-output-example .rag-example-complaint{
    margin-bottom:12px;
}

.smartops-rag-section .rag-gate-output-example .rag-code-block{
    max-height:390px;
}

.smartops-rag-section .rag-gate-example-case{
    position:relative;
    padding:15px 16px 15px 19px;
    border:1px solid #b9d9f6;
    border-left:4px solid var(--rag-blue);
    border-radius:11px;
    background:linear-gradient(135deg,#eef6ff,#fff);
}

.smartops-rag-section .rag-gate-example-case > span,
.smartops-rag-section .rag-gate-example-signals small,
.smartops-rag-section .rag-gate-example-decision small{
    display:block;
    color:#0874d1;
    font-size:8px;
    font-weight:900;
    letter-spacing:.1em;
}

.smartops-rag-section .rag-gate-example-case strong{
    display:block;
    margin-top:7px;
    color:var(--rag-ink);
    font-size:16px;
}

.smartops-rag-section .rag-gate-example-case p{
    margin:5px 0 10px;
    color:#38536d;
    font-size:11px;
    line-height:1.45;
}

.smartops-rag-section .rag-gate-example-case em{
    display:inline-flex;
    padding:5px 9px;
    border-radius:999px;
    background:#0c7de8;
    color:#fff;
    font-size:8px;
    font-style:normal;
    font-weight:900;
    letter-spacing:.06em;
}

.smartops-rag-section .rag-gate-example-signals{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:9px;
    margin-top:11px;
}

.smartops-rag-section .rag-gate-example-signals article{
    padding:12px;
    border:1px solid #cae0f2;
    border-radius:10px;
    background:#fff;
}

.smartops-rag-section .rag-gate-example-signals strong{
    display:block;
    margin-top:7px;
    color:var(--rag-ink);
    font-size:18px;
}

.smartops-rag-section .rag-gate-example-signals span{
    display:block;
    margin-top:4px;
    color:#078367;
    font-size:8px;
    font-weight:800;
}

.smartops-rag-section .rag-gate-example-decision{
    display:grid;
    grid-template-columns:minmax(0,.8fr) auto minmax(0,1.2fr);
    gap:9px;
    align-items:stretch;
    margin-top:11px;
}

.smartops-rag-section .rag-gate-example-decision article{
    display:flex;
    flex-direction:column;
    justify-content:center;
    min-height:72px;
    padding:11px 13px;
    border:1px solid #bfd9ef;
    border-radius:10px;
    background:#eef6ff;
}

.smartops-rag-section .rag-gate-example-decision article.ready{
    border-color:#91dbc7;
    background:#eafaf5;
}

.smartops-rag-section .rag-gate-example-decision strong{
    display:block;
    margin-top:6px;
    color:var(--rag-ink);
    font-size:15px;
}

.smartops-rag-section .rag-gate-example-decision .ready strong{
    color:#087e61;
}

.smartops-rag-section .rag-gate-example-decision span{
    margin-top:4px;
    color:#4f7469;
    font-size:8px;
}

.smartops-rag-section .rag-gate-example-decision > i{
    align-self:center;
    color:var(--rag-blue);
    font-size:18px;
    font-style:normal;
    font-weight:900;
}

.smartops-rag-section .rag-gate-control-result{
    display:grid;
    grid-template-columns:auto auto 1fr;
    gap:12px;
    align-items:center;
    margin-top:15px;
    padding:15px 17px;
    border:1px solid #a9dfd1;
    border-left:4px solid var(--rag-teal);
    border-radius:11px;
    background:#effbf7;
}

.smartops-rag-section .rag-gate-control-result span{
    color:#087e61;
    font-size:8px;
    font-weight:900;
    letter-spacing:.1em;
}

.smartops-rag-section .rag-gate-control-result strong{
    color:#087e61;
    font-size:12px;
}

.smartops-rag-section .rag-gate-control-result p{
    margin:0;
    color:#4f7469;
    font-size:9px;
    line-height:1.5;
}

@media(max-width:960px){
    .smartops-rag-section .rag-gate-simple,
    .smartops-rag-section .rag-gate-detail-grid{
        grid-template-columns:1fr;
    }
}

@media(max-width:560px){
    .smartops-rag-section .rag-gate-simple-visual{
        grid-template-columns:1fr;
    }

    .smartops-rag-section .rag-gate-simple-labels{
        grid-template-columns:repeat(3,1fr);
    }

    .smartops-rag-section .rag-gate-control-result{
        grid-template-columns:1fr;
    }

    .smartops-rag-section .rag-gate-example-signals,
    .smartops-rag-section .rag-gate-example-decision{
        grid-template-columns:1fr;
    }

    .smartops-rag-section .rag-gate-example-decision > i{
        transform:rotate(90deg);
        justify-self:center;
    }
}

/* ==========================================================
   CHAPTER 04 · ENGINEERED LLM SYSTEM + BOUNDED HARNESS LOOP
========================================================== */
.technology-section.smartops-rag-section .chapter-content > .chapter.rag-generation-chapter.active:not([hidden]){
    display:block !important;
    grid-template-columns:none !important;
}

.smartops-rag-section .chapter.rag-generation-chapter.active{
    display:block !important;
    grid-template-columns:none !important;
}

.smartops-rag-section .chapter.rag-generation-chapter[hidden]{
    display:none !important;
}

.smartops-rag-section .rag-generation-chapter{
    --llm-blue:#1769ff;
    --llm-sky:#0798d7;
    --llm-cyan:#12b8b0;
    --llm-violet:#7652c8;
    --llm-orange:#f07818;
    --llm-green:#0aa67f;
    --llm-red:#dc4c61;
    border-top-color:var(--llm-sky);
}

.smartops-rag-section .rag-generation-chapter .rag-chapter-heading{
    margin-bottom:20px;
}

.smartops-rag-section .rag-generation-chapter .rag-chapter-heading h3{
    max-width:900px;
}

.smartops-rag-section .rag-generation-chapter .rag-chapter-heading p{
    max-width:900px;
}

.smartops-rag-section .rag-generation-chapter .rag-chapter-status{
    border-color:#a9e3d4;
    background:#ecfaf6;
    color:#087e61;
}

.smartops-rag-section .rag-generation-chapter .rag-chapter-status span{
    background:#29c69d;
}

.smartops-rag-section .llm-section-card{
    position:relative;
    padding:22px;
    border:1px solid #c7dced;
    border-top:3px solid var(--llm-blue);
    border-radius:18px;
    background:
        linear-gradient(135deg,rgba(23,105,255,.035),rgba(18,184,176,.025)),
        #fff;
    box-shadow:0 18px 42px rgba(30,72,112,.095);
    overflow:hidden;
}

.smartops-rag-section .llm-section-card + .llm-section-card{
    margin-top:20px;
}

.smartops-rag-section .llm-section-card::before{
    content:"";
    position:absolute;
    width:260px;
    height:260px;
    right:-120px;
    top:-150px;
    border-radius:50%;
    background:radial-gradient(circle,rgba(23,105,255,.09),rgba(23,105,255,0) 70%);
    pointer-events:none;
}

.smartops-rag-section .llm-section-card.llm-harness-card{
    border-top-color:var(--llm-violet);
}

.smartops-rag-section .llm-section-heading{
    position:relative;
    z-index:1;
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:18px;
    margin-bottom:18px;
}

.smartops-rag-section .llm-section-kicker{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:6px;
}

.smartops-rag-section .llm-section-code{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:46px;
    height:28px;
    padding:0 11px;
    border:1px solid #98c5ff;
    border-radius:9px;
    background:#eaf4ff;
    color:var(--llm-blue);
    font-size:10px;
    font-weight:950;
    letter-spacing:.08em;
}

.smartops-rag-section .llm-section-heading h4{
    margin:0;
    color:#122b45;
    font-size:19px;
    line-height:1.2;
}

.smartops-rag-section .llm-section-heading p{
    max-width:760px;
    margin:5px 0 0;
    color:#71879e;
    font-size:10px;
    line-height:1.6;
}

.smartops-rag-section .llm-section-badge{
    flex:0 0 auto;
    display:inline-flex;
    align-items:center;
    gap:7px;
    min-height:30px;
    padding:0 12px;
    border:1px solid #b9d5e9;
    border-radius:999px;
    background:#f6fbff;
    color:#2b648d;
    font-size:8px;
    font-weight:950;
    letter-spacing:.11em;
    white-space:nowrap;
}

.smartops-rag-section .llm-section-badge::before{
    content:"";
    width:7px;
    height:7px;
    border-radius:50%;
    background:var(--llm-cyan);
    box-shadow:0 0 0 4px rgba(18,184,176,.12);
}

/* 04A: system around the model */
.smartops-rag-section .llm-system-grid{
    position:relative;
    z-index:1;
    display:grid;
    grid-template-columns:minmax(430px,1.35fr) minmax(300px,.85fr);
    grid-template-areas:
        "shell control"
        "engineering engineering";
    gap:16px 18px;
    align-items:stretch;
}

.smartops-rag-section .llm-shell-card,
.smartops-rag-section .llm-engineering-list,
.smartops-rag-section .llm-control-column{
    min-width:0;
}

.smartops-rag-section .llm-shell-card{
    grid-area:shell;
    display:flex;
    flex-direction:column;
    padding:15px;
    border:1px solid #d2e2ef;
    border-radius:15px;
    background:
        linear-gradient(rgba(23,105,255,.035) 1px,transparent 1px),
        linear-gradient(90deg,rgba(23,105,255,.035) 1px,transparent 1px),
        #f8fbff;
    background-size:28px 28px;
}

.smartops-rag-section .llm-shell-caption{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    margin-bottom:12px;
}

.smartops-rag-section .llm-shell-caption strong{
    color:#17324d;
    font-size:11px;
}

.smartops-rag-section .llm-shell-caption span{
    color:#7c90a4;
    font-size:10px;
    font-weight:800;
    letter-spacing:.08em;
}

.smartops-rag-section .llm-shell-visual{
    position:relative;
    min-height:430px;
    border-radius:20px;
    background:rgba(255,255,255,.62);
}

.smartops-rag-section .llm-shell-layer{
    position:absolute;
    border:2px solid currentColor;
    border-radius:20px;
    background:rgba(255,255,255,.46);
    box-shadow:inset 0 0 0 1px rgba(255,255,255,.78),0 9px 22px rgba(25,66,105,.045);
}

.smartops-rag-section .llm-shell-layer > span{
    position:absolute;
    top:10px;
    left:50%;
    transform:translateX(-50%);
    padding:0 8px;
    background:#fff;
    color:currentColor;
    font-size:13px;
    font-weight:950;
    letter-spacing:.19em;
    line-height:1;
    white-space:nowrap;
}

.smartops-rag-section .llm-shell-loop{
    inset:0;
    color:var(--llm-orange);
}

.smartops-rag-section .llm-shell-harness{
    inset:42px 26px 26px;
    color:var(--llm-violet);
}

.smartops-rag-section .llm-shell-output{
    inset:84px 54px 52px;
    color:var(--llm-cyan);
}

.smartops-rag-section .llm-shell-context{
    inset:126px 82px 78px;
    color:var(--llm-blue);
}

.smartops-rag-section .llm-model-core{
    position:absolute;
    left:50%;
    top:58%;
    transform:translate(-50%,-50%);
    display:grid;
    place-items:center;
    width:150px;
    height:100px;
    border:1px solid #f39a62;
    border-radius:16px;
    background:linear-gradient(145deg,#ff8a45,#f25d32);
    color:#fff;
    font-size:18px;
    font-weight:950;
    letter-spacing:.13em;
    box-shadow:0 14px 25px rgba(242,93,50,.22),inset 0 1px rgba(255,255,255,.45);
    z-index:5;
}

.smartops-rag-section .llm-engineering-list{
    grid-area:engineering;
    display:flex;
    flex-direction:column;
    padding:16px;
    border:1px solid #d2e2ef;
    border-radius:15px;
    background:#fff;
}

.smartops-rag-section .llm-column-title{
    display:flex;
    align-items:center;
    gap:8px;
    margin-bottom:10px;
    color:#1769ff;
    font-size:12px;
    font-weight:950;
    letter-spacing:.09em;
    text-transform:uppercase;
}

.smartops-rag-section .llm-column-title::before{
    content:"";
    width:18px;
    height:2px;
    border-radius:999px;
    background:linear-gradient(90deg,var(--llm-blue),var(--llm-cyan));
}

.smartops-rag-section .llm-engineering-items{
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:9px;
}

.smartops-rag-section .llm-engineering-item{
    display:grid;
    grid-template-columns:27px 1fr;
    gap:9px;
    align-items:flex-start;
    min-height:86px;
    padding:10px;
    border:1px solid #e1ebf3;
    border-radius:10px;
    background:#fbfdff;
}

.smartops-rag-section .llm-engineering-number{
    display:grid;
    place-items:center;
    width:27px;
    height:27px;
    border-radius:8px;
    background:#eaf4ff;
    color:var(--llm-blue);
    font-size:9px;
    font-weight:950;
}

.smartops-rag-section .llm-engineering-item:nth-child(2) .llm-engineering-number{background:#eaf8ff;color:#078ac4;}
.smartops-rag-section .llm-engineering-item:nth-child(3) .llm-engineering-number{background:#fff1e7;color:#df6c13;}
.smartops-rag-section .llm-engineering-item:nth-child(4) .llm-engineering-number{background:#eafaf7;color:#078b72;}
.smartops-rag-section .llm-engineering-item:nth-child(5) .llm-engineering-number{background:#f1edff;color:#6d4ac7;}
.smartops-rag-section .llm-engineering-item:nth-child(6) .llm-engineering-number{background:#fff6df;color:#b57708;}
.smartops-rag-section .llm-engineering-item:nth-child(7) .llm-engineering-number{background:#ecf7f3;color:#087c64;}

.smartops-rag-section .llm-engineering-item strong{
    display:block;
    margin:1px 0 2px;
    color:#17324d;
    font-size:10px;
    line-height:1.35;
}

.smartops-rag-section .llm-engineering-item p{
    margin:0;
    color:#71869a;
    font-size:12px;
    line-height:1.48;
}

.smartops-rag-section .llm-control-column{
    grid-area:control;
    display:grid;
    grid-template-columns:1fr;
    gap:12px;
}

.smartops-rag-section .llm-layer-legend{
    padding:15px;
    border:1px solid #d2e2ef;
    border-radius:15px;
    background:#f9fcff;
}

.smartops-rag-section .llm-layer-row{
    display:grid;
    grid-template-columns:14px 86px 1fr;
    gap:8px;
    align-items:flex-start;
    padding:12px 0;
    border-bottom:1px solid #e7eff5;
}

.smartops-rag-section .llm-layer-row:last-child{
    border-bottom:0;
}

.smartops-rag-section .llm-layer-dot{
    width:11px;
    height:11px;
    margin-top:4px;
    border-radius:3px;
    background:#a5b7c8;
    box-shadow:0 0 0 3px rgba(165,183,200,.13);
}

.smartops-rag-section .llm-layer-row:nth-child(2) .llm-layer-dot{background:var(--llm-blue);box-shadow:0 0 0 3px rgba(23,105,255,.12);}
.smartops-rag-section .llm-layer-row:nth-child(3) .llm-layer-dot{background:var(--llm-cyan);box-shadow:0 0 0 3px rgba(18,184,176,.12);}
.smartops-rag-section .llm-layer-row:nth-child(4) .llm-layer-dot{background:var(--llm-violet);box-shadow:0 0 0 3px rgba(118,82,200,.12);}
.smartops-rag-section .llm-layer-row:nth-child(5) .llm-layer-dot{background:var(--llm-orange);box-shadow:0 0 0 3px rgba(240,120,24,.12);}

.smartops-rag-section .llm-layer-row strong{
    color:#17324d;
    font-size:8.7px;
}

.smartops-rag-section .llm-layer-row p{
    margin:0;
    color:#778b9f;
    font-size:11px;
    line-height:1.5;
}




/* Chapter 04A sizing refinement: keep the control legend aligned to the diagram height. */
@media (min-width:901px){
    .smartops-rag-section .llm-shell-card,
    .smartops-rag-section .llm-control-column{
        height:490px;
        min-height:490px;
        max-height:490px;
    }

    .smartops-rag-section .llm-shell-card{
        overflow:hidden;
    }

    .smartops-rag-section .llm-shell-visual{
        flex:1 1 auto;
        min-height:0;
        height:auto;
    }

    .smartops-rag-section .llm-control-column{
        overflow:hidden;
    }

    .smartops-rag-section .llm-layer-legend{
        box-sizing:border-box;
        display:grid;
        grid-template-rows:auto repeat(5,minmax(0,1fr));
        height:100%;
        min-height:0;
        padding:15px 18px 12px;
        overflow:hidden;
    }

    .smartops-rag-section .llm-layer-legend .llm-column-title{
        margin-bottom:4px;
        font-size:13px;
    }

    .smartops-rag-section .llm-layer-row{
        grid-template-columns:16px 96px minmax(0,1fr);
        gap:10px;
        min-height:0;
        padding:8px 0;
        align-items:center;
    }

    .smartops-rag-section .llm-layer-dot{
        width:12px;
        height:12px;
        margin-top:0;
    }

    .smartops-rag-section .llm-layer-row strong{
        font-size:12px;
        line-height:1.25;
    }

    .smartops-rag-section .llm-layer-row p{
        font-size:12px;
        line-height:1.35;
    }
}

/* 04B: controlled harness loop */
.smartops-rag-section .llm-harness-canvas{
    position:relative;
    z-index:1;
    padding:18px 16px 16px;
    border:1px solid #d5e2ed;
    border-radius:15px;
    background:
        linear-gradient(90deg,rgba(23,105,255,.025) 1px,transparent 1px),
        #fbfdff;
    background-size:34px 34px;
}

.smartops-rag-section .llm-flow-row{
    display:grid;
    grid-template-columns:repeat(6,minmax(112px,1fr));
    gap:28px;
    align-items:stretch;
}

.smartops-rag-section .llm-flow-step{
    position:relative;
    min-height:128px;
    padding:14px 12px 12px;
    border:1px solid #9dc0dc;
    border-top:3px solid var(--step-color,var(--llm-blue));
    border-radius:13px;
    background:#fff;
    box-shadow:0 9px 22px rgba(29,70,110,.07);
}

.smartops-rag-section .llm-flow-step:not(:last-child)::after{
    content:"→";
    position:absolute;
    top:50%;
    right:-22px;
    transform:translateY(-50%);
    color:#f07818;
    font-size:20px;
    font-weight:950;
}

.smartops-rag-section .llm-flow-step.generate{--step-color:var(--llm-orange);}
.smartops-rag-section .llm-flow-step.verify{--step-color:var(--llm-violet);}
.smartops-rag-section .llm-flow-step.ground{--step-color:var(--llm-cyan);}
.smartops-rag-section .llm-flow-step.repair{--step-color:var(--llm-red);}
.smartops-rag-section .llm-flow-step.reverify{--step-color:var(--llm-blue);}
.smartops-rag-section .llm-flow-step.forward{--step-color:var(--llm-green);}

.smartops-rag-section .llm-flow-icon{
    display:grid;
    place-items:center;
    width:30px;
    height:30px;
    margin-bottom:10px;
    border-radius:9px;
    background:color-mix(in srgb,var(--step-color) 12%,white);
    color:var(--step-color);
    font-size:14px;
    font-weight:950;
}

.smartops-rag-section .llm-flow-step small{
    display:block;
    margin-bottom:3px;
    color:var(--step-color);
    font-size:7px;
    font-weight:950;
    letter-spacing:.12em;
}

.smartops-rag-section .llm-flow-step strong{
    display:block;
    color:#17324d;
    font-size:11px;
    line-height:1.25;
}

.smartops-rag-section .llm-flow-step p{
    margin:5px 0 0;
    color:#73879b;
    font-size:8.1px;
    line-height:1.45;
}

.smartops-rag-section .llm-loop-track{
    position:relative;
    height:62px;
    margin:2px 49px 0;
}

.smartops-rag-section .llm-loop-track::before{
    content:"";
    position:absolute;
    left:0;
    right:0;
    top:31px;
    border-top:2px dashed #f07818;
}

.smartops-rag-section .llm-loop-track::after{
    content:"↶";
    position:absolute;
    left:-5px;
    top:15px;
    color:#f07818;
    font-size:24px;
    font-weight:950;
}

.smartops-rag-section .llm-loop-return-arrow{
    position:absolute;
    right:-4px;
    top:13px;
    color:#f07818;
    font-size:24px;
    font-weight:950;
    transform:rotate(180deg);
}

.smartops-rag-section .llm-loop-label{
    position:absolute;
    left:50%;
    top:18px;
    transform:translateX(-50%);
    padding:5px 13px;
    border:1px solid #f0b37e;
    border-radius:999px;
    background:#fff8f1;
    color:#cf6411;
    font-size:8.5px;
    font-weight:950;
    white-space:nowrap;
}

.smartops-rag-section .llm-loop-stop{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    margin:-3px auto 14px;
    color:#a23b4b;
    font-size:8.3px;
    font-weight:850;
}

.smartops-rag-section .llm-loop-stop span{
    display:inline-flex;
    align-items:center;
    min-height:24px;
    padding:0 10px;
    border:1px solid #edbdc5;
    border-radius:999px;
    background:#fff7f8;
}

.smartops-rag-section .llm-loop-metrics{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:11px;
}

.smartops-rag-section .llm-loop-metric{
    display:grid;
    grid-template-columns:54px 1fr;
    gap:11px;
    align-items:center;
    min-height:88px;
    padding:13px;
    border:1px solid #d4e2ed;
    border-radius:13px;
    background:#fff;
}

.smartops-rag-section .llm-loop-metric strong{
    color:var(--metric-color,var(--llm-orange));
    font-size:35px;
    line-height:1;
}

.smartops-rag-section .llm-loop-metric:nth-child(2){--metric-color:var(--llm-violet);}
.smartops-rag-section .llm-loop-metric:nth-child(3){--metric-color:var(--llm-cyan);}
.smartops-rag-section .llm-loop-metric:nth-child(4){--metric-color:var(--llm-green);}

.smartops-rag-section .llm-loop-metric span{
    color:#667f95;
    font-size:8.4px;
    font-weight:800;
    line-height:1.45;
}

.smartops-rag-section .llm-loop-note{
    display:flex;
    align-items:center;
    gap:10px;
    margin-top:12px;
    padding:11px 14px;
    border:1px solid #f1c49e;
    border-left:4px solid var(--llm-orange);
    border-radius:11px;
    background:#fff8f1;
    color:#87502b;
    font-size:9px;
    font-weight:800;
    line-height:1.45;
}

.smartops-rag-section .llm-loop-note::before{
    content:"i";
    display:grid;
    place-items:center;
    flex:0 0 24px;
    width:24px;
    height:24px;
    border-radius:50%;
    background:#fff;
    color:var(--llm-orange);
    font-size:11px;
    font-weight:950;
    box-shadow:0 0 0 1px #efbd91;
}

@media(max-width:1260px){
    .smartops-rag-section .llm-flow-row{
        grid-template-columns:repeat(3,1fr);
        gap:18px 28px;
    }
    .smartops-rag-section .llm-flow-step:nth-child(3)::after{
        display:none;
    }
}

@media(max-width:900px){
    .smartops-rag-section .llm-system-grid{
        grid-template-columns:1fr;
        grid-template-areas:"shell" "control" "engineering";
    }
    .smartops-rag-section .llm-control-column{
        grid-template-columns:1fr 1fr;
    }
    .smartops-rag-section .llm-engineering-items{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }
    .smartops-rag-section .llm-flow-row{
        grid-template-columns:repeat(2,1fr);
    }
    .smartops-rag-section .llm-flow-step:nth-child(2)::after,
    .smartops-rag-section .llm-flow-step:nth-child(4)::after{
        display:none;
    }
    .smartops-rag-section .llm-flow-step:nth-child(3)::after{
        display:block;
    }
    .smartops-rag-section .llm-loop-metrics{
        grid-template-columns:repeat(2,1fr);
    }
}

@media(max-width:560px){
    .smartops-rag-section .llm-section-card{
        padding:16px;
    }
    .smartops-rag-section .llm-section-heading{
        display:block;
    }
    .smartops-rag-section .llm-section-badge{
        margin-top:10px;
    }
    .smartops-rag-section .llm-shell-visual{min-height:290px;}
    .smartops-rag-section .llm-shell-harness{inset:38px 18px 22px;}
    .smartops-rag-section .llm-shell-output{inset:76px 36px 44px;}
    .smartops-rag-section .llm-shell-context{inset:114px 56px 66px;}
    .smartops-rag-section .llm-control-column,
    .smartops-rag-section .llm-engineering-items,
    .smartops-rag-section .llm-flow-row,
    .smartops-rag-section .llm-loop-metrics{
        grid-template-columns:1fr;
    }
    .smartops-rag-section .llm-flow-step::after{
        display:none !important;
    }
    .smartops-rag-section .llm-loop-track{
        margin-left:18px;
        margin-right:18px;
    }
}

/* Gate 2: unmistakable green / yellow / red governance routes. */
.smartops-rag-section .rag-governance-chapter{
    border-top-color:#0aa67f;
}

.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes{
    gap:12px;
}

.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes > div{
    position:relative;
    min-height:250px;
    padding:20px 17px;
    border-width:1px;
    border-radius:14px;
    overflow:hidden;
}

.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes > div::before{
    content:"";
    position:absolute;
    inset:0 0 auto;
    height:5px;
}

.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes .approved{
    border-color:#9edbc4;
    background:linear-gradient(155deg,#fff,#e8f8f1);
    box-shadow:0 12px 28px rgba(10,166,127,.11);
}

.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes .approved::before{
    background:#0aa67f;
}

.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes .approved small,
.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes .approved strong{
    color:#08785d;
}

.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes .approved span{
    color:#3f7667;
}

.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes .review{
    border-color:#efd18f;
    background:linear-gradient(155deg,#fff,#fff3d9);
    box-shadow:0 12px 28px rgba(216,138,22,.11);
}

.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes .review::before{
    background:#e2a11d;
}

.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes .review small,
.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes .review strong{
    color:#9a620a;
}

.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes .review span{
    color:#87682e;
}

.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes .blocked{
    border-color:#efadb7;
    background:linear-gradient(155deg,#fff,#fde9ed);
    box-shadow:0 12px 28px rgba(214,76,93,.10);
}

.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes .blocked::before{
    background:#d64c5d;
}

.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes .blocked small,
.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes .blocked strong{
    color:#b52e41;
}

.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes .blocked span{
    color:#96515b;
}

.smartops-rag-section .rag-governance-chapter .rag-validation-stack > div{
    border-color:#cfe0ed;
    background:#fff;
}

.smartops-rag-section .rag-governance-chapter .rag-validation-stack span{
    background:#eaf4ff;
    color:#1769ff;
}

.smartops-rag-section .rag-governance-chapter .rag-validation-stack strong{
    color:var(--rag-ink);
}

.smartops-rag-section .rag-governance-chapter .rag-validation-stack i{
    background:#e1f8ef;
    color:#0aa67f;
}

.smartops-rag-section .rag-governance-chapter .rag-action-bar{
    border-color:#c9deed;
    background:linear-gradient(120deg,#f7fbff,#eaf5ff);
}

.smartops-rag-section .rag-governance-chapter .rag-action-bar small{
    color:#526f88;
}

.smartops-rag-section .rag-governance-chapter .rag-action-bar strong{
    color:#173b59;
}

.smartops-rag-section .rag-governance-chapter .rag-action-bar .rag-business-button{
    border:0;
    background:linear-gradient(135deg,#1769ff,#087fc4);
    color:#fff;
    font-size:10px;
    box-shadow:0 9px 20px rgba(23,105,255,.18);
}

.smartops-rag-section .rag-governance-chapter .rag-action-bar .rag-business-button.secondary{
    border:1px solid #78afe2;
    background:#fff;
    color:#1263ad;
    box-shadow:0 8px 18px rgba(24,67,112,.08);
}

.smartops-rag-section .rag-governance-chapter .rag-action-bar .rag-business-button.secondary:hover{
    border-color:#1769ff;
    background:#edf6ff;
    color:#0e54a0;
}

/* Concrete Gate 2 cases for business-pitch explanation. */
.smartops-rag-section .rag-governance-example-grid article{
    min-height:390px;
    display:flex;
    flex-direction:column;
    padding:20px;
    box-shadow:0 12px 28px rgba(24,67,112,.07);
}

.smartops-rag-section .rag-example-case-head{
    display:flex;
    flex-wrap:wrap;
    gap:7px;
    align-items:center;
    justify-content:space-between;
}

.smartops-rag-section .rag-example-case-head span,
.smartops-rag-section .rag-example-case-head b{
    font-size:8px;
    font-weight:900;
    letter-spacing:.08em;
}

.smartops-rag-section .rag-example-case-head b{
    padding:6px 8px;
    border-radius:999px;
}

.smartops-rag-section .rag-governance-example-grid .approved .rag-example-case-head span{
    color:#087e61;
}

.smartops-rag-section .rag-governance-example-grid .approved .rag-example-case-head b{
    background:#d9f4ea;
    color:#087e61;
}

.smartops-rag-section .rag-governance-example-grid .review .rag-example-case-head span{
    color:#a4660c;
}

.smartops-rag-section .rag-governance-example-grid .review .rag-example-case-head b{
    background:#ffe9bd;
    color:#9a620a;
}

.smartops-rag-section .rag-governance-example-grid .blocked .rag-example-case-head span{
    color:#bd3448;
}

.smartops-rag-section .rag-governance-example-grid .blocked .rag-example-case-head b{
    background:#fbdce1;
    color:#b52e41;
}

.smartops-rag-section .rag-example-case-complaint{
    min-height:62px;
    margin:0 0 14px;
    padding:12px;
    border:1px solid rgba(72,116,154,.14);
    border-radius:9px;
    background:rgba(255,255,255,.72);
    color:#365d7d;
    font-size:10px;
    font-style:italic;
    line-height:1.55;
}

.smartops-rag-section .rag-decision-facts{
    display:grid;
    gap:0;
    margin:0;
    border:1px solid rgba(72,116,154,.14);
    border-radius:10px;
    background:#fff;
    overflow:hidden;
}

.smartops-rag-section .rag-decision-facts > div{
    display:grid;
    grid-template-columns:92px 1fr;
    gap:10px;
    padding:9px 11px;
    border-bottom:1px solid #e6eef5;
}

.smartops-rag-section .rag-decision-facts > div:last-child{
    border-bottom:0;
}

.smartops-rag-section .rag-decision-facts dt,
.smartops-rag-section .rag-decision-facts dd{
    margin:0;
    font-size:9px;
    line-height:1.4;
}

.smartops-rag-section .rag-decision-facts dt{
    color:#71869a;
    font-weight:800;
}

.smartops-rag-section .rag-decision-facts dd{
    color:#173b59;
    font-weight:850;
}

.smartops-rag-section .rag-decision-result{
    margin-top:auto;
    padding:13px;
    border-radius:10px;
}

.smartops-rag-section .rag-decision-result small,
.smartops-rag-section .rag-decision-result strong{
    display:block;
}

.smartops-rag-section .rag-decision-result small{
    font-size:7px;
    font-weight:900;
    letter-spacing:.1em;
}

.smartops-rag-section .rag-decision-result strong{
    margin-top:4px;
    font-size:11px;
}

.smartops-rag-section .rag-governance-example-grid .approved .rag-decision-result{
    background:#dff6ed;
    color:#087e61;
}

.smartops-rag-section .rag-governance-example-grid .review .rag-decision-result{
    background:#ffedc8;
    color:#925d0b;
}

.smartops-rag-section .rag-governance-example-grid .blocked .rag-decision-result{
    background:#fbe0e4;
    color:#ad2e40;
}

@media(max-width:900px){
    .smartops-rag-section .rag-governance-example-grid{
        grid-template-columns:1fr;
    }

    .smartops-rag-section .rag-governance-example-grid article{
        min-height:0;
    }

    .smartops-rag-section .rag-decision-result{
        margin-top:15px;
    }
}

/* ==========================================================
   CHAPTER 07 · COMPLETE GOVERNED SYSTEM
========================================================== */

.smartops-rag-section .rag-e2e-board{
    overflow:hidden;
    margin-top:22px;
    border:1px solid rgba(30,101,184,.16);
    border-radius:18px;
    background:#f8fbff;
}

.smartops-rag-section .rag-e2e-lane{
    display:grid;
    grid-template-columns:126px minmax(0,1fr);
    min-width:0;
    border-bottom:1px solid rgba(30,101,184,.12);
}

.smartops-rag-section .rag-e2e-lane:last-child{
    border-bottom:0;
}

.smartops-rag-section .rag-e2e-lane-label{
    display:flex;
    flex-direction:column;
    justify-content:center;
    min-height:128px;
    padding:17px;
    color:#fff;
    background:linear-gradient(145deg,#0b315e,#071f3e);
}

.smartops-rag-section .rag-e2e-lane-system .rag-e2e-lane-label{
    background:linear-gradient(145deg,#1769ff,#0a429f);
}

.smartops-rag-section .rag-e2e-lane-label small,
.smartops-rag-section .rag-e2e-lane-label strong{
    display:block;
    color:#fff;
}

.smartops-rag-section .rag-e2e-lane-label small{
    margin-bottom:5px;
    opacity:.68;
    font-size:7px;
    font-weight:900;
    letter-spacing:.1em;
}

.smartops-rag-section .rag-e2e-lane-label strong{
    font-size:12px;
    line-height:1.3;
    letter-spacing:.01em;
}

.smartops-rag-section .rag-e2e-lane-content{
    min-width:0;
    display:flex;
    align-items:center;
    padding:16px;
    background:
        linear-gradient(rgba(23,105,255,.035) 1px,transparent 1px),
        linear-gradient(90deg,rgba(23,105,255,.035) 1px,transparent 1px),
        #fff;
    background-size:24px 24px;
}

.smartops-rag-section .rag-e2e-track{
    width:100%;
    display:flex;
    align-items:center;
    gap:7px;
}

.smartops-rag-section .rag-e2e-node{
    min-width:0;
    flex:1 1 0;
    min-height:80px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    padding:11px 10px;
    border:1px solid rgba(30,101,184,.20);
    border-radius:11px;
    background:#fff;
    box-shadow:0 7px 17px rgba(24,67,112,.07);
}

.smartops-rag-section .rag-e2e-node small,
.smartops-rag-section .rag-e2e-node strong,
.smartops-rag-section .rag-e2e-node span{
    display:block;
}

.smartops-rag-section .rag-e2e-node small{
    margin-bottom:4px;
    color:#1769ff;
    font-size:7px;
    font-weight:900;
    letter-spacing:.08em;
    text-transform:uppercase;
}

.smartops-rag-section .rag-e2e-node strong{
    color:#10233a;
    font-size:10px;
    line-height:1.35;
}

.smartops-rag-section .rag-e2e-node span{
    margin-top:4px;
    color:#6f8498;
    font-size:7px;
    line-height:1.35;
}

.smartops-rag-section .rag-e2e-arrow{
    flex:0 0 12px;
    color:#1769ff;
    font-size:13px;
    font-style:normal;
    font-weight:900;
    text-align:center;
}

.smartops-rag-section .rag-e2e-gate{
    border-color:#66a0ff;
    background:linear-gradient(145deg,#f2f7ff,#fff);
}

.smartops-rag-section .rag-e2e-gate strong{
    color:#0b4eb9;
}

.smartops-rag-section .rag-e2e-outcomes{
    display:grid;
    gap:3px;
    margin-top:7px;
}

.smartops-rag-section .rag-e2e-outcomes b{
    padding:3px 5px;
    border-radius:5px;
    color:#087c51;
    background:#e8f8f1;
    font-size:6px;
    font-weight:900;
    line-height:1.2;
}

.smartops-rag-section .rag-e2e-outcomes b:nth-child(2){
    color:#a45c00;
    background:#fff3dd;
}

.smartops-rag-section .rag-e2e-outcomes b:nth-child(3){
    color:#b72d3b;
    background:#fdebed;
}

.smartops-rag-section .rag-e2e-guest-track .rag-e2e-node{
    max-width:190px;
    min-height:70px;
}

.smartops-rag-section .rag-e2e-route-line{
    position:relative;
    flex:1 1 auto;
    height:2px;
    background:linear-gradient(90deg,#1769ff,#15b879);
}

.smartops-rag-section .rag-e2e-route-line::after{
    content:"→";
    position:absolute;
    top:50%;
    right:-2px;
    transform:translateY(-54%);
    color:#15a56e;
    font-size:15px;
    font-weight:900;
}

.smartops-rag-section .rag-e2e-route-line span{
    position:absolute;
    left:50%;
    bottom:8px;
    transform:translateX(-50%);
    color:#557087;
    font-size:7px;
    font-weight:900;
    white-space:nowrap;
    letter-spacing:.08em;
    text-transform:uppercase;
}

.smartops-rag-section .rag-e2e-human-track,
.smartops-rag-section .rag-e2e-technician-track{
    max-width:690px;
    margin:0 auto;
}

.smartops-rag-section .rag-e2e-technician-track{
    max-width:840px;
}

.smartops-rag-section .rag-e2e-lane-human .rag-e2e-node{
    border-color:#f0cf93;
    background:#fffaf1;
}

.smartops-rag-section .rag-e2e-lane-human .rag-e2e-node small{
    color:#a45c00;
}

.smartops-rag-section .rag-e2e-lane-technician .rag-e2e-node{
    border-color:#a9dbc9;
    background:#f3fbf8;
}

.smartops-rag-section .rag-e2e-lane-technician .rag-e2e-node small{
    color:#087c51;
}

.smartops-rag-section .rag-e2e-lane-technician .rag-e2e-final-outcome{
    border-color:#15b879;
    background:linear-gradient(145deg,#e6f8f0,#f7fffb);
    box-shadow:0 9px 22px rgba(21,184,121,.13);
}

.smartops-rag-section .rag-e2e-lane-technician .rag-e2e-final-outcome strong{
    color:#087c51;
}

.smartops-rag-section .rag-e2e-principle{
    display:grid;
    grid-template-columns:auto minmax(0,1fr) auto;
    align-items:center;
    gap:10px;
    margin-top:16px;
    padding:15px 17px;
    border:1px solid rgba(23,105,255,.22);
    border-radius:13px;
    background:linear-gradient(90deg,#eaf4ff,#f8fbff);
}

.smartops-rag-section .rag-e2e-principle > span:first-child{
    width:38px;
    height:38px;
    display:grid;
    place-items:center;
    border-radius:11px;
    color:#fff;
    background:#1769ff;
    font-weight:900;
}

.smartops-rag-section .rag-e2e-principle strong,
.smartops-rag-section .rag-e2e-principle small{
    display:block;
}

.smartops-rag-section .rag-e2e-principle strong{
    color:#0b4eb9;
    font-size:13px;
}

.smartops-rag-section .rag-e2e-principle small{
    margin-top:2px;
    color:#6f8498;
    font-size:8px;
}

.smartops-rag-section .rag-e2e-principle > span:last-child{
    color:#087c51;
    font-size:7px;
    font-weight:900;
    letter-spacing:.08em;
    white-space:nowrap;
    text-transform:uppercase;
}

@media(max-width:1180px){
    .smartops-rag-section .rag-e2e-system-track{
        display:grid;
        grid-template-columns:repeat(3,minmax(0,1fr));
    }

    .smartops-rag-section .rag-e2e-system-track .rag-e2e-arrow{
        display:none;
    }
}

@media(max-width:680px){
    .smartops-rag-section .rag-e2e-lane{
        grid-template-columns:1fr;
    }

    .smartops-rag-section .rag-e2e-lane-label{
        min-height:0;
        padding:12px 15px;
    }

    .smartops-rag-section .rag-e2e-track,
    .smartops-rag-section .rag-e2e-system-track{
        display:grid;
        grid-template-columns:1fr;
        gap:8px;
    }

    .smartops-rag-section .rag-e2e-arrow,
    .smartops-rag-section .rag-e2e-system-track .rag-e2e-arrow{
        display:block;
        transform:rotate(90deg);
    }

    .smartops-rag-section .rag-e2e-guest-track .rag-e2e-node{
        max-width:none;
    }

    .smartops-rag-section .rag-e2e-route-line{
        width:2px;
        height:28px;
        justify-self:center;
        background:linear-gradient(#1769ff,#15b879);
    }

    .smartops-rag-section .rag-e2e-route-line::after{
        content:"↓";
        top:auto;
        right:auto;
        bottom:-8px;
        left:50%;
        transform:translateX(-50%);
    }

    .smartops-rag-section .rag-e2e-route-line span{
        display:none;
    }

    .smartops-rag-section .rag-e2e-principle{
        grid-template-columns:auto minmax(0,1fr);
    }

    .smartops-rag-section .rag-e2e-principle > span:last-child{
        grid-column:1 / -1;
    }
}



/* Retained Showcase NEXT STAGE navigation cards inside the SOps full framework */
.smartops-rag-section .rag-framework-next-wrap {
  display: flex;
  justify-content: flex-end;
  margin-top: 30px;
  padding-top: 8px;
}

.smartops-rag-section .rag-framework-next-link {
  width: min(100%, 430px);
  max-width: 430px;
  min-width: 0;
  display: grid;
  gap: 5px;
  padding: 15px 19px;
  border: 1px solid rgba(93, 218, 174, .52);
  border-radius: 22px;
  background: linear-gradient(135deg, rgba(45, 133, 116, .88), rgba(48, 92, 105, .88));
  box-shadow: inset 0 1px 0 rgba(255,255,255,.09), 0 18px 42px rgba(25, 98, 93, .12);
  text-align: left;
}

.smartops-rag-section .rag-framework-next-link small {
  color: #91e7c8;
  font-size: 11px;
  line-height: 1;
  font-weight: 900;
  letter-spacing: .18em;
}

.smartops-rag-section .rag-framework-next-link strong {
  color: #c6f8df;
  font-size: clamp(16px, 1.25vw, 20px);
  line-height: 1.25;
}

.smartops-rag-section .rag-framework-next-link span {
  color: #a7d9c8;
  font-size: 12px;
  line-height: 1.4;
}

@media (max-width: 760px) {
  .smartops-rag-section .rag-framework-next-wrap {
    justify-content: stretch;
  }
  .smartops-rag-section .rag-framework-next-link {
    width: 100%;
    max-width: none;
    border-radius: 22px;
  }
}


/* 2026-08-03 · Chapter 07 placement + persistent pipeline sidebar */
@media (min-width:1021px){
  .smartops-rag-section .rag-stage-navigation{
    position:sticky !important;
    top:96px !important;
    align-self:flex-start;
    max-height:calc(100vh - 116px);
    overflow-y:auto;
    overscroll-behavior:contain;
  }
}
.how-smartops-after-rag{
  clear:both;
  padding-top:0;
  background:#f5f9fd;
}
.how-smartops-after-rag .how-smartops-restored{
  margin-top:0;
}


/* Chapter 04A control legend readability refinement */
.smartops-rag-section .llm-layer-legend{
    padding:18px 20px;
}
.smartops-rag-section .llm-layer-row{
    grid-template-columns:18px 118px minmax(0,1fr);
    gap:10px;
    align-items:center;
    min-height:92px;
    padding:16px 0;
}
.smartops-rag-section .llm-layer-dot{
    width:14px;
    height:14px;
    margin-top:0;
    border-radius:4px;
    box-shadow:0 0 0 5px rgba(165,183,200,.13);
}
.smartops-rag-section .llm-layer-row:nth-child(2) .llm-layer-dot{box-shadow:0 0 0 5px rgba(23,105,255,.12);}
.smartops-rag-section .llm-layer-row:nth-child(3) .llm-layer-dot{box-shadow:0 0 0 5px rgba(18,184,176,.12);}
.smartops-rag-section .llm-layer-row:nth-child(4) .llm-layer-dot{box-shadow:0 0 0 5px rgba(118,82,200,.12);}
.smartops-rag-section .llm-layer-row:nth-child(5) .llm-layer-dot{box-shadow:0 0 0 5px rgba(240,120,24,.12);}
.smartops-rag-section .llm-layer-row strong{
    font-size:13px;
    line-height:1.25;
    white-space:nowrap;
}
.smartops-rag-section .llm-layer-row p{
    font-size:13px;
    line-height:1.48;
}
@media (max-width:1100px){
    .smartops-rag-section .llm-layer-row{
        grid-template-columns:16px 102px minmax(0,1fr);
        min-height:82px;
        gap:12px;
        padding:13px 0;
    }
    .smartops-rag-section .llm-layer-row strong,
    .smartops-rag-section .llm-layer-row p{font-size:12px;}
}


/* Chapter 04A control legend: compact rows, readable text, no overflow. */
@media (min-width:901px){
  .smartops-rag-section .llm-system-grid{
    grid-template-columns:minmax(500px,1.28fr) minmax(360px,.92fr);
  }
  .smartops-rag-section .llm-layer-legend{
    grid-template-rows:auto repeat(5,74px);
    align-content:start;
    padding:15px 16px 12px;
  }
  .smartops-rag-section .llm-layer-legend .llm-column-title{
    margin-bottom:6px;
  }
  .smartops-rag-section .llm-layer-row{
    grid-template-columns:16px 76px minmax(0,1fr);
    column-gap:8px;
    min-height:74px;
    height:74px;
    padding:8px 0;
    align-items:center;
    box-sizing:border-box;
  }
  .smartops-rag-section .llm-layer-row strong{
    font-size:12.5px;
    line-height:1.2;
    white-space:nowrap;
  }
  .smartops-rag-section .llm-layer-row p{
    font-size:11.5px;
    line-height:1.35;
    overflow-wrap:normal;
    word-break:normal;
    hyphens:none;
  }
}


/* ==========================================================
   Parent–child section and KB example: larger presentation text
========================================================== */
.smartops-rag-section #parent-child-section .rag-chapter-code{
    font-size:13px !important;
}
.smartops-rag-section #parent-child-section h3{
    font-size:25px !important;
    line-height:1.2 !important;
}
.smartops-rag-section #parent-child-section p{
    font-size:14px !important;
    line-height:1.65 !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-content-card,
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-system-card{
    min-height:480px !important;
    padding:26px !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-card-label{
    font-size:11px !important;
    letter-spacing:.14em !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-content-card > h4{
    margin-top:12px !important;
    font-size:31px !important;
    line-height:1.22 !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-content-card > p{
    font-size:15px !important;
    line-height:1.65 !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-feature-stack{
    gap:12px !important;
    margin-top:23px !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-feature-stack > div{
    gap:14px !important;
    padding:16px !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-feature-stack i{
    width:38px !important;
    height:38px !important;
    flex-basis:38px !important;
    font-size:12px !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-feature-stack strong{
    font-size:15px !important;
    line-height:1.3 !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-feature-stack small{
    margin-top:5px !important;
    font-size:12px !important;
    line-height:1.5 !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-business-button{
    padding:14px 18px !important;
    font-size:12px !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-parent-card{
    padding:25px !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-parent-card small,
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-child-card small{
    font-size:12px !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-parent-card strong{
    font-size:24px !important;
    line-height:1.3 !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-parent-card span{
    font-size:15px !important;
    line-height:1.55 !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-link-line b{
    font-size:10px !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-child-card{
    padding:22px !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-child-card strong{
    font-size:18px !important;
    line-height:1.3 !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-child-card span{
    font-size:12px !important;
    line-height:1.45 !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-indexing-rule{
    padding:16px !important;
    gap:10px !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-indexing-rule span{
    width:34px !important;
    height:34px !important;
    font-size:10px !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-indexing-rule strong{
    font-size:11px !important;
}
.smartops-rag-section #parent-child-section + .rag-chapter-grid .rag-indexing-rule b{
    font-size:18px !important;
}

.smartops-rag-section #kbExampleModal .rag-modal-shell{
    max-width:1080px !important;
}
.smartops-rag-section #kbExampleModal .rag-modal-header{
    padding:24px 26px !important;
}
.smartops-rag-section #kbExampleModal .rag-modal-header small{
    font-size:13px !important;
}
.smartops-rag-section #kbExampleModal .rag-modal-header h3{
    font-size:31px !important;
    line-height:1.25 !important;
}
.smartops-rag-section #kbExampleModal .rag-modal-content{
    padding:26px !important;
}
.smartops-rag-section #kbExampleModal .rag-example-complaint{
    padding:17px 19px !important;
}
.smartops-rag-section #kbExampleModal .rag-example-complaint span{
    font-size:12px !important;
}
.smartops-rag-section #kbExampleModal .rag-example-complaint strong{
    font-size:18px !important;
    line-height:1.5 !important;
}
.smartops-rag-section #kbExampleModal .rag-kb-modal-layout{
    gap:16px !important;
    margin-top:20px !important;
}
.smartops-rag-section #kbExampleModal .rag-kb-parent,
.smartops-rag-section #kbExampleModal .rag-kb-child{
    padding:22px !important;
}
.smartops-rag-section #kbExampleModal .rag-modal-card-label{
    font-size:12px !important;
}
.smartops-rag-section #kbExampleModal .rag-kb-parent h4,
.smartops-rag-section #kbExampleModal .rag-kb-child h4{
    font-size:24px !important;
    line-height:1.3 !important;
}
.smartops-rag-section #kbExampleModal .rag-kb-parent dl{
    gap:11px !important;
}
.smartops-rag-section #kbExampleModal .rag-kb-parent dl > div{
    grid-template-columns:155px 1fr !important;
    padding-bottom:10px !important;
}
.smartops-rag-section #kbExampleModal .rag-kb-parent dt,
.smartops-rag-section #kbExampleModal .rag-kb-parent dd{
    font-size:15px !important;
    line-height:1.55 !important;
}
.smartops-rag-section #kbExampleModal .rag-kb-link-label strong{
    font-size:12px !important;
}
.smartops-rag-section #kbExampleModal .rag-kb-child-grid{
    gap:14px !important;
}
.smartops-rag-section #kbExampleModal .rag-kb-child ul{
    font-size:15px !important;
    line-height:1.8 !important;
}
.smartops-rag-section #kbExampleModal .rag-modal-process{
    gap:12px !important;
    margin-top:20px !important;
}
.smartops-rag-section #kbExampleModal .rag-modal-process > div{
    min-height:145px !important;
    padding:18px !important;
}
.smartops-rag-section #kbExampleModal .rag-modal-process span{
    font-size:12px !important;
}
.smartops-rag-section #kbExampleModal .rag-modal-process strong{
    font-size:18px !important;
    line-height:1.4 !important;
}
.smartops-rag-section #kbExampleModal .rag-modal-process small{
    font-size:14px !important;
    line-height:1.6 !important;
}

@media(max-width:720px){
    .smartops-rag-section #kbExampleModal .rag-kb-parent dl > div{
        grid-template-columns:1fr !important;
        gap:5px !important;
    }
}



/* Gate 2 typography + sidebar size refinement */
.smartops-rag-section .rag-governance-chapter .rag-chapter-code {
  font-size: 12px !important;
}
.smartops-rag-section .rag-governance-chapter .rag-chapter-heading h3 {
  font-size: clamp(42px, 4.4vw, 60px) !important;
  line-height: 1.08 !important;
}
.smartops-rag-section .rag-governance-chapter .rag-chapter-heading p {
  font-size: 18px !important;
  line-height: 1.6 !important;
}
.smartops-rag-section .rag-governance-chapter .rag-chapter-status {
  font-size: 12px !important;
  padding: 12px 18px !important;
}
.smartops-rag-section .rag-governance-chapter .rag-validation-stack > div {
  min-height: 72px !important;
  padding: 18px 18px !important;
}
.smartops-rag-section .rag-governance-chapter .rag-validation-stack span {
  width: 34px !important;
  height: 34px !important;
  font-size: 11px !important;
}
.smartops-rag-section .rag-governance-chapter .rag-validation-stack strong {
  font-size: 20px !important;
  line-height: 1.35 !important;
}
.smartops-rag-section .rag-governance-chapter .rag-validation-stack i {
  width: 34px !important;
  height: 34px !important;
  font-size: 22px !important;
}
.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes > div {
  min-height: 280px !important;
  padding: 22px 18px !important;
}
.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes small {
  font-size: 11px !important;
}
.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes strong {
  font-size: 20px !important;
  line-height: 1.35 !important;
}
.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes span {
  font-size: 17px !important;
  line-height: 1.55 !important;
}
.smartops-rag-section .rag-governance-chapter .rag-action-bar small {
  font-size: 11px !important;
}
.smartops-rag-section .rag-governance-chapter .rag-action-bar strong {
  font-size: 20px !important;
  line-height: 1.45 !important;
}
.smartops-rag-section .rag-governance-chapter .rag-action-bar .rag-business-button,
.smartops-rag-section .rag-governance-chapter .rag-action-bar .rag-business-button.secondary {
  min-height: 56px !important;
  font-size: 16px !important;
  padding: 0 18px !important;
}

.smartops-rag-section .rag-stage-navigation {
  width: 308px !important;
  padding: 18px !important;
}
.smartops-rag-section .rag-stage-navigation::before {
  font-size: 10px !important;
  padding-bottom: 12px !important;
}
.smartops-rag-section .rag-stage-button {
  min-height: 84px !important;
  padding: 16px 14px !important;
  border-radius: 16px !important;
  gap: 14px !important;
}
.smartops-rag-section .rag-stage-button .stage-index {
  flex: 0 0 44px !important;
  width: 44px !important;
  height: 44px !important;
  font-size: 13px !important;
  border-radius: 12px !important;
}
.smartops-rag-section .rag-stage-button .stage-copy strong {
  font-size: 18px !important;
  line-height: 1.28 !important;
}
.smartops-rag-section .rag-stage-button .stage-copy em {
  margin-top: 4px !important;
  font-size: 12px !important;
  line-height: 1.35 !important;
}
.smartops-rag-section .rag-stage-parent {
  padding-right: 48px !important;
}
.smartops-rag-section .stage-chevron {
  right: 18px !important;
  width: 10px !important;
  height: 10px !important;
}
.smartops-rag-section .rag-subnav {
  padding-left: 34px !important;
}
.smartops-rag-section .rag-subnav-button {
  min-height: 66px !important;
}
.smartops-rag-section .rag-subnav-button > span:first-child {
  font-size: 11px !important;
}
.smartops-rag-section .rag-subnav-button strong {
  font-size: 15px !important;
}
.smartops-rag-section .rag-subnav-button em {
  font-size: 11px !important;
}



/* Gate 2 outcome cards: keep headings inside the boxes */
.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes > div {
  overflow: hidden;
}
.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes strong {
  display: block !important;
  width: 100% !important;
  font-size: 17px !important;
  line-height: 1.22 !important;
  overflow-wrap: anywhere !important;
  word-break: break-word !important;
  white-space: normal !important;
}
.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes span {
  font-size: 15px !important;
  line-height: 1.5 !important;
}



/* Gate 2 decision examples modal: larger fonts */
.smartops-rag-section #governanceModal .rag-modal-shell{
  max-width: 1180px !important;
}
.smartops-rag-section #governanceModal .rag-modal-header small{
  font-size: 13px !important;
}
.smartops-rag-section #governanceModal .rag-modal-header h3{
  font-size: 33px !important;
  line-height: 1.22 !important;
}
.smartops-rag-section #governanceModal .rag-governance-example-grid article{
  padding: 22px 20px !important;
}
.smartops-rag-section #governanceModal .rag-example-case-head span,
.smartops-rag-section #governanceModal .rag-example-case-head b{
  font-size: 11px !important;
}
.smartops-rag-section #governanceModal .rag-governance-example-grid h4{
  font-size: 17px !important;
  line-height: 1.45 !important;
}
.smartops-rag-section #governanceModal .rag-example-case-complaint{
  font-size: 14px !important;
  line-height: 1.65 !important;
}
.smartops-rag-section #governanceModal .rag-decision-facts dt,
.smartops-rag-section #governanceModal .rag-decision-facts dd{
  font-size: 13px !important;
  line-height: 1.5 !important;
}
.smartops-rag-section #governanceModal .rag-decision-result small{
  font-size: 11px !important;
}
.smartops-rag-section #governanceModal .rag-decision-result strong{
  font-size: 15px !important;
  line-height: 1.45 !important;
}
.smartops-rag-section #governanceModal .rag-governance-summary strong{
  font-size: 18px !important;
}
.smartops-rag-section #governanceModal .rag-governance-summary span{
  font-size: 14px !important;
  line-height: 1.6 !important;
}



/* Gate 2 balance tweak: smaller left checklist and outcome titles fit on one line */
.smartops-rag-section .rag-governance-chapter .rag-validation-stack > div {
  min-height: 62px !important;
  padding: 14px 16px !important;
}
.smartops-rag-section .rag-governance-chapter .rag-validation-stack span {
  width: 30px !important;
  height: 30px !important;
  font-size: 10px !important;
}
.smartops-rag-section .rag-governance-chapter .rag-validation-stack strong {
  font-size: 17px !important;
  line-height: 1.3 !important;
}
.smartops-rag-section .rag-governance-chapter .rag-validation-stack i {
  width: 30px !important;
  height: 30px !important;
  font-size: 18px !important;
}
.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes > div {
  min-height: 264px !important;
  padding: 18px 16px !important;
}
.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes small {
  font-size: 10px !important;
}
.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes strong {
  font-size: 16px !important;
  line-height: 1.16 !important;
  letter-spacing: 0 !important;
  word-break: normal !important;
  overflow-wrap: normal !important;
}
.smartops-rag-section .rag-governance-chapter .rag-governance-outcomes span {
  font-size: 14px !important;
  line-height: 1.48 !important;
}



/* Gate 1 control modal + frontend adapter modal font enlargement */
.smartops-rag-section #gate1Modal .rag-modal-shell,
.smartops-rag-section #adapterModal .rag-modal-shell {
  max-width: 1180px !important;
}
.smartops-rag-section #gate1Modal .rag-modal-header small,
.smartops-rag-section #adapterModal .rag-modal-header small {
  font-size: 13px !important;
}
.smartops-rag-section #gate1Modal .rag-modal-header h3,
.smartops-rag-section #adapterModal .rag-modal-header h3 {
  font-size: 33px !important;
  line-height: 1.22 !important;
}
.smartops-rag-section #gate1Modal .rag-modal-card-label,
.smartops-rag-section #adapterModal .rag-modal-card-label {
  font-size: 12px !important;
}
.smartops-rag-section #gate1Modal h4 {
  font-size: 21px !important;
  line-height: 1.35 !important;
}
.smartops-rag-section #gate1Modal .rag-gate-component-list article {
  padding: 14px 14px !important;
}
.smartops-rag-section #gate1Modal .rag-gate-component-list article span {
  width: 38px !important;
  height: 38px !important;
  font-size: 11px !important;
}
.smartops-rag-section #gate1Modal .rag-gate-component-list article strong {
  font-size: 17px !important;
  line-height: 1.4 !important;
}
.smartops-rag-section #gate1Modal .rag-gate-component-list article p {
  font-size: 14px !important;
  line-height: 1.6 !important;
}
.smartops-rag-section #gate1Modal .rag-example-complaint span {
  font-size: 12px !important;
}
.smartops-rag-section #gate1Modal .rag-example-complaint strong {
  font-size: 18px !important;
  line-height: 1.5 !important;
}
.smartops-rag-section #gate1Modal .rag-code-block,
.smartops-rag-section #adapterModal .rag-code-block {
  font-size: 14px !important;
  line-height: 1.55 !important;
}
.smartops-rag-section #gate1Modal .rag-gate-control-result span {
  font-size: 12px !important;
}
.smartops-rag-section #gate1Modal .rag-gate-control-result strong {
  font-size: 19px !important;
}
.smartops-rag-section #gate1Modal .rag-gate-control-result p {
  font-size: 14px !important;
  line-height: 1.6 !important;
}

.smartops-rag-section #adapterModal .rag-adapter-metrics {
  gap: 12px !important;
}
.smartops-rag-section #adapterModal .rag-adapter-metrics > div {
  min-height: 74px !important;
  padding: 14px 16px !important;
}
.smartops-rag-section #adapterModal .rag-adapter-metrics small {
  font-size: 11px !important;
}
.smartops-rag-section #adapterModal .rag-adapter-metrics strong {
  font-size: 16px !important;
  line-height: 1.4 !important;
}
.smartops-rag-section #adapterModal .rag-code-note {
  font-size: 14px !important;
  line-height: 1.65 !important;
}

</style>
</head>
<body>
  <div class="site-progress" aria-hidden="true"><span id="siteProgress"></span></div>

  <header class="site-header" id="siteHeader">
    <a class="brand" href="#home" aria-label="SmartOps AI home">
      <span class="brand-copy">
        <strong>Smart<span>Ops</span> AI</strong>
        <small>Operational Maintenance Intelligence</small>
      </span>
    </a>

    <button class="nav-toggle" id="navToggle" type="button" aria-expanded="false" aria-controls="siteNav" aria-label="Open navigation">
      <span></span><span></span><span></span>
    </button>

    <nav class="site-nav" id="siteNav" aria-label="Primary navigation">
      <a href="#home">Home</a>
      <a href="#lifecycle">Lifecycle</a>
      <a href="#why-rag">Why RAG-LLM</a>
      <a href="#technology">RAG-LLM</a>
      <a href="#integration">Integration</a>
      <a href="#platform">Platform</a>
      <a href="#live-demo">Live Demo</a>
        <a href="#business-value">Business Value</a>
        <a href="#cost">Cost</a>
        <a href="#sustainability">Sustainability</a>
        <a href="#future-vision">Future Evolution</a>
    </nav>
  </header>

  <main>
    <section class="hero section-grid" id="home" data-section="home">
      <div class="hero-noise" aria-hidden="true"></div>
      <div class="hero-orb hero-orb-one" aria-hidden="true"></div>
      <div class="hero-orb hero-orb-two" aria-hidden="true"></div>

      <div class="hero-copy reveal">
        <div class="eyebrow"><span class="pulse-dot"></span> RAG-LLM Powered · Human Governed</div>
        <h1>Operational maintenance<br><span>turned into intelligent action</span></h1>
        <p class="hero-lead">SmartOps AI transforms guest maintenance complaints into grounded recommendations human governed decisions and actionable technician tasks</p>
        <p class="hero-context">Demonstrated through an end-to-end <strong>hotel operational maintenance</strong> workflow</p>
        <div class="hero-actions">
          <a class="button button-primary" href="#problem">Explore SmartOps AI <span>↓</span></a>
          <a class="button button-secondary" href="#live-demo">Launch Live Demo <span>↓</span></a>
        </div>
        <div class="hero-proof">
          <span>WhatsApp intake</span>
          <span>Grounded RAG</span>
          <span>HITL governance</span>
          <span>Technician workflow</span>
        </div>
      </div>

      <div class="hero-visual reveal" aria-label="SmartOps AI complaint-to-action visual">
        <div class="visual-grid" aria-hidden="true"></div>
        <figure class="hero-photo-panel">
          <img src="assets/photos/hero-technician.webp" alt="Operational maintenance technician inspecting facility equipment.">
          <figcaption><span>LIVE OPERATIONS</span><strong>Maintenance intelligence connected to real work</strong></figcaption>
        </figure>
        <div class="signal-line signal-one" aria-hidden="true"></div>
        <div class="signal-line signal-two" aria-hidden="true"></div>

        <article class="device-card phone-card">
          <div class="phone-top"><span></span><small>10:21</small><i></i></div>
          <div class="phone-chat-head">
            <span class="mini-logo">S</span>
            <div><strong>SmartOps Assistant</strong><small>Business Account</small></div>
          </div>
          <div class="chat-bubble guest">Hi, I’m in Room 305. The air-conditioning is leaking water near the indoor unit.</div>
          <div class="chat-bubble system">Your complaint has been received and is being analysed.</div>
          <div class="phone-input">Message <span>➤</span></div>
        </article>

        <article class="device-card ai-card">
          <div class="card-topline"><span>AI ANALYSIS</span><i class="live-indicator">LIVE</i></div>
          <div class="analysis-title"><span class="brain-icon">AI</span><div><small>CASE SSAI-305</small><strong>HVAC Leakage</strong></div></div>
          <dl class="analysis-list">
            <div><dt>Category</dt><dd>D30 HVAC</dd></div>
            <div><dt>Severity</dt><dd class="severity">HIGH</dd></div>
            <div><dt>Routing</dt><dd>HITL Review</dd></div>
          </dl>
          <div class="confidence-row"><span>Retrieval confidence</span><strong>94%</strong></div>
          <div class="confidence-track"><span></span></div>
          <div class="ai-tags"><span>Troubleshooting</span><span>Preventive</span></div>
        </article>

        <article class="device-card ops-card">
          <div class="ops-header"><span>OPERATIONS</span><i></i></div>
          <div class="ops-stat"><small>Pending review</small><strong>1</strong></div>
          <div class="ops-flow">
            <span class="flow-node active">Manager</span><b>→</b><span class="flow-node">Technician</span>
          </div>
          <div class="ops-status"><span></span> Human decision required</div>
        </article>

        <div class="hero-caption"><span>01 Capture</span><span>02 Analyse</span><span>03 Manage</span></div>
      </div>
    </section>

    <section class="content-section problem-section" id="problem">
      <div class="section-heading reveal">
        <span class="section-number">01</span>
        <div>
          <div class="section-kicker">Business Problem</div>
          <h2>The operational maintenance challenge</h2>
          <p>A hotel use case showing how manual handovers, limited troubleshooting support and poor task visibility delay maintenance resolution.</p>
        </div>
      </div>

      <div class="media-split">
        <div class="video-shell reveal">
          <div class="video-label"><span class="record-dot"></span> Hotel operational maintenance use case</div>
          <div class="problem-video-stage">
            <video id="problemVideo" playsinline webkit-playsinline preload="metadata" poster="slides/slide02.png">
              <source src="videos/slide02.mp4" type="video/mp4">
            </video>
            <button class="problem-video-start" id="problemVideoStart" type="button" aria-label="Start the business problem video">
              <span class="problem-video-play-icon" aria-hidden="true">▶</span>
              <span class="problem-video-start-copy">
                <strong>Start Video</strong>
                <small>Press to play</small>
              </span>
            </button>
          </div>
          <div class="video-caption"><strong>25-second scenario</strong><span>Press Start to play · replay after ending</span></div>
        </div>

        <div class="challenge-grid reveal">
          <article class="challenge-card">
            <span class="challenge-index">01</span>
            <h3>Manual Information Handover</h3>
            <p>Guest issues are manually passed from the front desk to technicians, causing delays and information loss.</p>
          </article>
          <article class="challenge-card">
            <span class="challenge-index">02</span>
            <h3>Slow Troubleshooting Support</h3>
            <p>Technicians may rely on senior staff for guidance, slowing down diagnosis and issue resolution.</p>
          </article>
          <article class="challenge-card">
            <span class="challenge-index">03</span>
            <h3>Limited Task Progress Visibility</h3>
            <p>Managers cannot clearly track the technician’s current task stage, progress or delays.</p>
          </article>
          <article class="challenge-card">
            <span class="challenge-index">04</span>
            <h3>Inefficient Prioritisation &amp; Assignment</h3>
            <p>Issues are manually prioritised and assigned without consistently considering severity, skills and workload.</p>
          </article>
        </div>
      </div>
    </section>

    <section class="content-section solution-section" id="solution">
      <div class="section-heading reveal">
        <span class="section-number">02</span>
        <div>
          <div class="section-kicker">Proposed Solution</div>
          <h2>From complaint to maintenance action</h2>
          <p>Three connected product capabilities followed by one real Room 305 operational case</p>
        </div>
      </div>

      <div class="three-stage solution-stage-visuals reveal" aria-label="SmartOps three-stage solution">
        <article class="stage-card stage-whatsapp">
          <div class="stage-top"><span>01</span><small>COLLECT</small></div>
          <figure class="stage-product-visual stage-real-visual">
            <img src="assets/photos/solution-collect-industrial.webp" alt="Room 305 QR code and WhatsApp maintenance complaint intake.">
            <figcaption><span>ROOM 305</span><strong>QR scan to WhatsApp intake</strong></figcaption>
          </figure>
          <h3>WhatsApp Intelligence</h3>
          <p>Scan the room QR code and send the maintenance complaint through WhatsApp</p>
          <span class="stage-output">QR intake · Room and issue details</span>
        </article>

        <div class="stage-connector"><span></span></div>

        <article class="stage-card featured stage-rag">
          <div class="stage-top"><span>02</span><small>ANALYSE</small></div>
          <figure class="stage-product-visual stage-real-visual stage-real-visual-dark">
            <img src="assets/photos/solution-rag-industrial.webp" alt="Industrial RAG-LLM maintenance intelligence interface showing classification evidence and recommended actions.">
            <figcaption><span>RAG-LLM ENGINE</span><strong>Evidence-grounded maintenance intelligence</strong></figcaption>
          </figure>
          <h3>RAG-LLM Intelligence</h3>
          <p>Classify the issue retrieve trusted evidence and generate grounded maintenance guidance</p>
          <span class="stage-output">Severity · Troubleshooting · Prevention</span>
        </article>

        <div class="stage-connector"><span></span></div>

        <article class="stage-card stage-platform">
          <div class="stage-top"><span>03</span><small>MANAGE</small></div>
          <figure class="stage-product-visual stage-real-visual stage-real-visual-dark">
            <img src="assets/photos/solution-platform-industrial.webp" alt="Web-based operational maintenance dashboard for case monitoring and technician assignment.">
            <figcaption><span>OPERATIONS PLATFORM</span><strong>Monitor route and assign maintenance work</strong></figcaption>
          </figure>
          <h3>Web-Based Platform</h3>
          <p>Govern high-risk cases assign technicians and monitor the maintenance workflow</p>
          <span class="stage-output">HITL · Dashboard · Technician task</span>
        </article>
      </div>

      <div class="case-study-grid case-study-original-size">
        <div class="video-shell solution-video-shell reveal">
          <div class="video-label"><span class="record-dot"></span> SmartOps AI in action · Room 305</div>
          <video id="solutionVideo" muted playsinline preload="auto" controls poster="slides/slide03.png">
            <source src="videos/slide03.mp4" type="video/mp4">
          </video>
          <div class="video-caption"><strong>End-to-end solution</strong><span>Complaint → AI analysis → HITL approval → technician response</span></div>
        </div>

        <div class="case-panel reveal">
          <div class="case-panel-head">
            <div><small>REAL CASE STUDY</small><h3>Room 305 · HVAC Leakage</h3></div>
          </div>

          <div class="case-timeline" id="caseTimeline">
            <button class="case-step active" type="button" data-seek="0">
              <span class="case-step-number">01</span>
              <span class="case-step-body"><strong>Complaint Received</strong><small>WhatsApp · Room 305</small></span>
              <i></i>
            </button>
            <div class="case-detail active" data-detail="0">
              <dl><div><dt>Location</dt><dd>Room 305</dd></div><div><dt>Issue</dt><dd>Water leaking from the air-conditioning unit</dd></div></dl>
            </div>

            <button class="case-step" type="button" data-seek="6">
              <span class="case-step-number">02</span>
              <span class="case-step-body"><strong>SmartOps AI Analysis</strong><small>Grounded RAG-LLM output</small></span>
              <i></i>
            </button>
            <div class="case-detail case-analysis-detail" data-detail="1">
              <dl class="case-analysis-rows">
                <div>
                  <dt>Category</dt>
                  <dd>D30 HVAC</dd>
                </div>
                <div class="case-analysis-severity-row">
                  <dt>Severity</dt>
                  <dd><strong>HIGH</strong><span>HITL Required</span></dd>
                </div>
                <div>
                  <dt>Outcome</dt>
                  <dd>Manager Review</dd>
                </div>
              </dl>
              <div class="case-chips"><span>Troubleshooting</span><span>Preventive Maintenance</span></div>
            </div>

            <button class="case-step" type="button" data-seek="10">
              <span class="case-step-number">03</span>
              <span class="case-step-body"><strong>Human-Governed Action</strong><small>Manager approval and assignment</small></span>
              <i></i>
            </button>
            <div class="case-detail" data-detail="2">
              <div class="mini-flow"><span>Manager reviews</span><b>→</b><span>Approves</span><b>→</b><span>Assigns technician</span></div>
            </div>
          </div>
          <p class="case-note">The case steps follow the video timeline and the human-governed action begins at approximately 0:10</p>
        </div>
      </div>
    </section>
    <section class="content-section lifecycle-section" id="lifecycle" data-section="lifecycle">
      <div class="section-heading reveal">
        <span class="section-number">03</span>
        <div>
          <div class="section-kicker">Product Development Lifecycle</div>
          <h2>How SmartOps AI was built</h2>
          <p>The original Parallel Project Life Cycle is presented below in the same website layout using the final visual diagram</p>
        </div>
      </div>

      <div class="coded-diagram-shell lifecycle-code-shell reveal">
        <div class="coded-diagram-head">
          <div><span>PARALLEL SDLC</span><h3>Parallel Project Life Cycle</h3></div>
          <p>AI and web development progress in parallel before integration testing and deployment</p>
        </div>
        <div class="coded-diagram-scroll">
          <div class="lifecycle-image-visual" role="img" aria-label="Parallel Project Life Cycle diagram showing business requirements and architecture planning flowing into AI RAG-LLM development and Agile Scrum web development before integration, testing, and deployment.">
            <img src="assets/diagrams/lifecycle-diagram-with-iteration-arrows-v3.png?v=20260801-1638" alt="Parallel Project Life Cycle industrial diagram">
            <a class="lifecycle-text-link lifecycle-link-ai" href="#technology">OPEN RAG-LLM →</a>
            <a class="lifecycle-text-link lifecycle-link-web" href="#platform">OPEN PLATFORM →</a>
          </div>
        </div>
      </div>
    </section>
    <section class="content-section why-section positioning-section" id="smartops-positioning-template" hidden aria-hidden="true">
      <div class="section-heading reveal">
        <span class="section-number">04</span>
        <div>
          <div class="section-kicker">SmartOps AI Positioning</div>
          <h2>Make maintenance expertise available beyond the individual</h2>
          <p>SmartOps AI captures maintenance know-how from trusted procedures and transforms it into clear, accessible guidance that can be shared and applied across the workforce.</p>
        </div>
      </div>

      <div class="positioning-compare reveal" aria-label="Previous hotel RAG study compared with SmartOps AI">
        <article class="positioning-card study-card">
          <div class="positioning-card-head">
            <span class="positioning-index">01</span>
            <div><small>PREVIOUS HOTEL RAG STUDY</small><h3>Guest information assistant</h3></div>
          </div>

          <div class="study-browser" aria-hidden="true">
            <div class="browser-bar"><i></i><i></i><i></i><span>Hotel service chatbot</span></div>
            <div class="browser-body">
              <div class="chat-bubble guest">Hotel information?</div>
              <div class="study-topics"><span>Services</span><span>Room availability</span><span>Packages</span><span>FAQs</span></div>
              <div class="chat-bubble bot"><b>RAG</b> retrieves hotel documents and generates a relevant response.</div>
            </div>
          </div>

          <div class="positioning-outcome"><span>PRIMARY OUTCOME</span><strong>Reliable guest-facing information</strong></div>
          <div class="positioning-reference">(Wijaya &amp; Jayadianti, 2026)</div>
        </article>

        <div class="positioning-shift" aria-hidden="true">
          <span>RAG-LLM</span><i></i><strong>extended into operations</strong>
        </div>

        <article class="positioning-card smartops-card">
          <div class="positioning-card-head">
            <span class="positioning-index">02</span>
            <div><small>SMARTOPS AI</small><h3>Maintenance knowledge-transfer platform</h3></div>
          </div>

          <div class="smartops-console" aria-hidden="true">
            <div class="console-query"><span>REPORT</span><strong>“The air conditioner is leaking.”</strong></div>
            <div class="console-grid">
              <div><small>CLASSIFY</small><strong>D30 HVAC</strong></div>
              <div><small>STRUCTURE</small><strong>Failure knowledge</strong></div>
              <div><small>RETRIEVE</small><strong>Troubleshooting</strong></div>
              <div><small>TRANSFER</small><strong>Workforce guidance</strong></div>
            </div>
          </div>

          <div class="positioning-outcome smartops-outcome"><span>PRIMARY OUTCOME</span><strong>Shared, accessible maintenance expertise</strong></div>
        </article>
      </div>

      <div class="knowledge-transfer reveal">
        <div class="knowledge-transfer-copy">
          <span>KNOWLEDGE ENGINEERING &amp; TRANSFER</span>
          <h3>Turn individual expertise into shared maintenance knowledge</h3>
          <p>SmartOps AI captures maintenance know-how, structures it into an organisational resource, retrieves the right procedures and delivers clear guidance employees can apply when needed.</p>
        </div>

        <div class="knowledge-transfer-cards" aria-label="Maintenance knowledge engineering and transfer flow">
          <article class="knowledge-transfer-card"><i>01</i><strong>Capture</strong><small>Manuals, records and employee know-how</small></article>
          <article class="knowledge-transfer-card"><i>02</i><strong>Engineer</strong><small>Structured scenarios, procedures and relationships</small></article>
          <article class="knowledge-transfer-card"><i>03</i><strong>Retrieve &amp; Translate</strong><small>RAG retrieves evidence, LLM delivers clear guidance</small></article>
          <article class="knowledge-transfer-card"><i>04</i><strong>Transfer &amp; Apply</strong><small>Shared expertise employees can access and use</small></article>
        </div>

        <div class="knowledge-transfer-tags" aria-label="Key workforce outcomes">
          <span>Knowledge retention</span><span>Faster onboarding</span><span>Consistent decisions</span><span>Less dependence on individuals</span>
        </div>
      </div>

      <div class="positioning-statement reveal">
        <span>OUR POSITION</span>
        <strong>Previous hotel RAG systems help guests access information. SmartOps AI helps organisations retain, transfer and apply maintenance expertise across the workforce.</strong>
        <a href="https://www.researchgate.net/publication/400696783_Implementation_of_RAG-Based_LLM_Chatbot_for_Hotel_Services_A_Case_Study" target="_blank" rel="noopener">View related hotel RAG study ↗</a>
      </div>
    </section>

    <section class="content-section why-section positioning-section" id="why-rag" data-section="why-rag">
      <div class="section-heading reveal">
        <span class="section-number">04</span>
        <div>
          <div class="section-kicker">Why RAG-LLM</div>
          <h2>Why RAG-LLM matters for operational maintenance</h2>
          <p>Understand the intelligence architecture first and then compare the operational outcome</p>
        </div>
      </div>

      <div class="rag-learning-shell rag-concept-showcase reveal">
        <div class="rag-concept-intro">
          <div>
            <span>PART ONE · WHAT IS RAG?</span>
            <h3>Retrieval-Augmented Generation</h3>
          </div>
          <p>RAG retrieves relevant information from a trusted maintenance knowledge base and gives that evidence to the LLM before the answer is generated.</p>
        </div>

        <div class="rag-concept-grid">
          <article class="rag-concept-card rag-evidence-card">
            <header>
              <div class="rag-concept-icon" aria-hidden="true">
                <svg viewBox="0 0 48 48"><ellipse cx="19" cy="11" rx="11" ry="5"/><path d="M8 11v20c0 3 5 5 11 5s11-2 11-5V11M8 21c0 3 5 5 11 5s11-2 11-5"/><circle cx="35" cy="31" r="7"/><path d="m40 36 5 5"/></svg>
              </div>
              <div>
                <small>RAG EVIDENCE LAYER</small>
                <h4>Connect the complaint to the right knowledge</h4>
              </div>
            </header>
            <p>Instead of asking the LLM to answer from general patterns alone, SmartOps first finds the operational evidence most likely to support the maintenance decision.</p>

            <div class="rag-concept-list rag-step-list">
              <div>
                <i>01</i>
                <span><strong>Search</strong><small>Find relevant SOPs, maintenance scenarios and technical records.</small></span>
              </div>
              <div>
                <i>02</i>
                <span><strong>Select</strong><small>Choose the strongest and most relevant supporting evidence.</small></span>
              </div>
              <div>
                <i>03</i>
                <span><strong>Provide context</strong><small>Add the selected evidence to the LLM prompt before generation.</small></span>
              </div>
            </div>
          </article>

          <article class="rag-concept-card rag-benefit-card">
            <header>
              <div class="rag-concept-icon" aria-hidden="true">
                <svg viewBox="0 0 48 48"><path d="M24 5 39 11v11c0 10-6 17-15 21C15 39 9 32 9 22V11l15-6Z"/><path d="m17 24 5 5 10-12"/></svg>
              </div>
              <div>
                <small>WHY RAG IS USEFUL</small>
                <h4>Grounded, traceable and maintainable intelligence</h4>
              </div>
            </header>
            <p>The knowledge base can be updated without retraining the whole language model, while every generated recommendation remains linked to retrieved evidence.</p>

            <div class="rag-concept-list rag-benefit-list">
              <div>
                <i>✓</i>
                <span><strong>Uses specialised knowledge</strong><small>Connects the model to hotel SOPs, scenarios and maintenance procedures.</small></span>
              </div>
              <div>
                <i>✓</i>
                <span><strong>Improves traceability</strong><small>Shows what evidence was retrieved before the recommendation was produced.</small></span>
              </div>
              <div>
                <i>✓</i>
                <span><strong>Supports fresher answers</strong><small>Updates the knowledge base when procedures change without retraining the LLM.</small></span>
              </div>
            </div>
          </article>
        </div>

        <div class="rag-context-bridge" aria-label="RAG context preparation flow">
          <div><i>01</i><span><small>INPUT</small><strong>Guest complaint</strong></span></div>
          <b>→</b>
          <div><i>02</i><span><small>RETRIEVE</small><strong>Relevant knowledge</strong></span></div>
          <b>→</b>
          <div><i>03</i><span><small>SELECT</small><strong>Trusted evidence</strong></span></div>
          <b>→</b>
          <div class="rag-context-ready"><i>04</i><span><small>CONTEXT READY</small><strong>Evidence sent to LLM</strong></span></div>
        </div>

        <div class="llm-concept-showcase">
          <div class="llm-concept-intro">
            <div>
              <span>PART TWO · WHAT IS AN LLM?</span>
              <h3>What is an LLM?</h3>
            </div>
            <p>An LLM, or large language model, is an AI system trained to understand and generate human language.</p>
          </div>

          <div class="llm-concept-grid">
            <article class="llm-concept-card llm-strength-card">
              <header>
                <small>WHAT IT DOES WELL</small>
                <h4>Turns information into clear, useful language</h4>
              </header>
              <p>An LLM recognises language patterns and transforms information into readable explanations, summaries and recommendations.</p>

              <div class="llm-concept-list">
                <div>
                  <i>✓</i>
                  <span><strong>Understands questions</strong><small>Interprets informal wording, complaint details and user intent.</small></span>
                </div>
                <div>
                  <i>✓</i>
                  <span><strong>Generates clear language</strong><small>Explains technical information in a practical and readable form.</small></span>
                </div>
                <div>
                  <i>✓</i>
                  <span><strong>Structures answers</strong><small>Creates summaries, action steps and maintenance recommendations.</small></span>
                </div>
              </div>
            </article>

            <article class="llm-concept-card llm-limit-card">
              <header>
                <small>WHAT IT CANNOT GUARANTEE ALONE</small>
                <h4>Fluent answers are not always grounded answers</h4>
              </header>
              <p>Without retrieval, an LLM does not automatically check the latest private, operational or domain-specific information before answering.</p>

              <div class="llm-concept-list llm-limit-list">
                <div>
                  <i>!</i>
                  <span><strong>Trusted evidence</strong><small>A confident answer may still be unsupported by the correct maintenance source.</small></span>
                </div>
                <div>
                  <i>!</i>
                  <span><strong>Current operational knowledge</strong><small>The model may not know the latest SOPs, records or hotel procedures.</small></span>
                </div>
                <div>
                  <i>!</i>
                  <span><strong>Correct domain context</strong><small>Specialised maintenance terms can be misunderstood without retrieved evidence.</small></span>
                </div>
              </div>
            </article>
          </div>

          <div class="rag-llm-concept-bridge" aria-label="RAG and LLM relationship">
            <div><small>RAG</small><strong>Supplies trusted maintenance evidence</strong></div>
            <b>→</b>
            <div><small>LLM</small><strong>Turns that evidence into clear operational guidance</strong></div>
          </div>
        </div>

      <div class="positioning-subheading reveal">
        <div class="section-kicker">SmartOps AI Positioning</div>
        <h3>Make maintenance expertise available beyond the individual</h3>
        <p>SmartOps AI captures maintenance know-how from trusted procedures and transforms it into clear, accessible guidance that can be shared and applied across the workforce.</p>
      </div>

      <div class="positioning-compare reveal" aria-label="Previous hotel RAG study compared with SmartOps AI">
        <article class="positioning-card study-card">
          <div class="positioning-card-head">
            <span class="positioning-index">01</span>
            <div><small>PREVIOUS HOTEL RAG STUDY</small><h3>Guest information assistant</h3></div>
          </div>

          <div class="study-browser" aria-hidden="true">
            <div class="browser-bar"><i></i><i></i><i></i><span>Hotel service chatbot</span></div>
            <div class="browser-body">
              <div class="chat-bubble guest">Hotel information?</div>
              <div class="study-topics"><span>Services</span><span>Room availability</span><span>Packages</span><span>FAQs</span></div>
              <div class="chat-bubble bot"><b>RAG</b> retrieves hotel documents and generates a relevant response.</div>
            </div>
          </div>

          <div class="positioning-outcome"><span>PRIMARY OUTCOME</span><strong>Reliable guest-facing information</strong></div>
          <div class="positioning-reference">(Wijaya &amp; Jayadianti, 2026)</div>
        </article>

        <div class="positioning-shift" aria-hidden="true"><span>RAG-LLM</span><i></i><strong>extended into operations</strong></div>

        <article class="positioning-card smartops-card">
          <div class="positioning-card-head">
            <span class="positioning-index">02</span>
            <div><small>SMARTOPS AI</small><h3>Maintenance knowledge-transfer platform</h3></div>
          </div>

          <div class="smartops-console" aria-hidden="true">
            <div class="console-query"><span>REPORT</span><strong>“The air conditioner is leaking.”</strong></div>
            <div class="console-grid">
              <div><small>CLASSIFY</small><strong>D30 HVAC</strong></div>
              <div><small>STRUCTURE</small><strong>Failure knowledge</strong></div>
              <div><small>RETRIEVE</small><strong>Troubleshooting</strong></div>
              <div><small>TRANSFER</small><strong>Workforce guidance</strong></div>
            </div>
          </div>

          <div class="positioning-outcome smartops-outcome"><span>PRIMARY OUTCOME</span><strong>Shared, accessible maintenance expertise</strong></div>
        </article>
      </div>

      <div class="knowledge-transfer reveal">
        <div class="knowledge-transfer-copy">
          <span>KNOWLEDGE ENGINEERING &amp; TRANSFER</span>
          <h3>Turn individual expertise into shared maintenance knowledge</h3>
          <p>SmartOps AI captures maintenance know-how, structures it into an organisational resource, retrieves the right procedures and delivers clear guidance employees can apply when needed.</p>
        </div>

        <div class="knowledge-transfer-cards" aria-label="Maintenance knowledge engineering and transfer flow">
          <article class="knowledge-transfer-card"><i>01</i><strong>Capture</strong><small>Manuals, records and employee know-how</small></article>
          <article class="knowledge-transfer-card"><i>02</i><strong>Engineer</strong><small>Structured scenarios, procedures and relationships</small></article>
          <article class="knowledge-transfer-card"><i>03</i><strong>Retrieve &amp; Translate</strong><small>RAG retrieves evidence, LLM delivers clear guidance</small></article>
          <article class="knowledge-transfer-card"><i>04</i><strong>Transfer &amp; Apply</strong><small>Shared expertise employees can access and use</small></article>
        </div>

        <div class="knowledge-transfer-tags" aria-label="Key workforce outcomes">
          <span>Knowledge retention</span><span>Faster onboarding</span><span>Consistent decisions</span><span>Less dependence on individuals</span>
        </div>
      </div>

      <div class="positioning-statement reveal">
        <span>OUR POSITION</span>
        <strong>Previous hotel RAG systems help guests access information. SmartOps AI helps organisations retain, transfer and apply maintenance expertise across the workforce.</strong>
        <a href="https://www.researchgate.net/publication/400696783_Implementation_of_RAG-Based_LLM_Chatbot_for_Hotel_Services_A_Case_Study" target="_blank" rel="noopener">View related hotel RAG study ↗</a>
      </div>

      <div class="friend-why-ragllm reveal" aria-label="Why RAG-LLM matters comparison" hidden aria-hidden="true">
        <div class="friend-why-grid" aria-hidden="true"></div>
        <div class="container">
          <div class="section-head">
            <div>
              <div class="kicker">Why the connection matters</div>
              <h2>Why RAG-LLM matters</h2>
            </div>
            <p>A model can sound confident even when it does not have the correct source. RAG gives the LLM relevant evidence and makes the answer easier to verify.</p>
          </div>

          <div class="comparison-shell">
            <div class="comparison">
              <article class="compare-card bad">
                <div class="compare-header">
                  <div>
                    <div class="compare-label">WITHOUT RAG</div>
                    <h3>LLM answers alone</h3>
                    <p class="compare-subtitle">The model responds directly from general learned patterns without consulting trusted maintenance evidence.</p>
                  </div>
                </div>

                <div class="compare-flow">
                  <div class="compare-step">
                    <span class="compare-step-number">01</span>
                    <span class="compare-icon">
                      <svg viewBox="0 0 48 48" aria-hidden="true"><path d="M10 9h28a4 4 0 0 1 4 4v17a4 4 0 0 1-4 4H24l-9 7v-7h-5a4 4 0 0 1-4-4V13a4 4 0 0 1 4-4Z"/><circle cx="18" cy="22" r="1.5"/><circle cx="24" cy="22" r="1.5"/><circle cx="30" cy="22" r="1.5"/></svg>
                    </span>
                    <strong>Guest complaint</strong>
                  </div>
                  <div class="compare-step">
                    <span class="compare-step-number">02</span>
                    <span class="compare-icon">
                      <svg viewBox="0 0 48 48" aria-hidden="true"><path d="M17 12a6 6 0 0 1 11-3 6 6 0 0 1 7 8 6 6 0 0 1 2 11 6 6 0 0 1-8 8 6 6 0 0 1-10 1 6 6 0 0 1-8-8 6 6 0 0 1 1-11 6 6 0 0 1 5-6Z"/><path d="M24 8v32M17 16h7M24 22h8M15 29h9M24 34h6"/></svg>
                    </span>
                    <strong>LLM only</strong>
                  </div>
                  <div class="compare-step">
                    <span class="compare-step-number">03</span>
                    <span class="compare-icon">
                      <svg viewBox="0 0 48 48" aria-hidden="true"><path d="M9 10h30a4 4 0 0 1 4 4v18a4 4 0 0 1-4 4H25l-9 7v-7H9a4 4 0 0 1-4-4V14a4 4 0 0 1 4-4Z"/><path d="M17 23h.01M24 23h.01M31 23h.01"/></svg>
                    </span>
                    <strong>Generic answer</strong>
                  </div>
                  <div class="compare-step">
                    <span class="compare-step-number">04</span>
                    <span class="compare-icon">
                      <svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="24" cy="26" r="15"/><path d="M24 11V6M19 6h10M24 26l7-6M35 13l4 4"/></svg>
                    </span>
                    <strong>Slower action</strong>
                  </div>
                </div>

                <div class="compare-points">
                  <div class="point"><i>×</i><span>No trusted maintenance evidence</span></div>
                  <div class="point"><i>×</i><span>Higher unsupported-answer risk</span></div>
                  <div class="point"><i>×</i><span>More manual interpretation by staff</span></div>
                </div>
              </article>

              <div class="vs"><span>VS</span></div>

              <article class="compare-card good">
                <div class="compare-header">
                  <div>
                    <div class="compare-label">WITH RAG-LLM</div>
                    <h3>Evidence before generation</h3>
                    <p class="compare-subtitle">SmartOps retrieves relevant operational knowledge first, then uses the LLM to explain the supported action.</p>
                  </div>
                </div>

                <div class="compare-flow">
                  <div class="compare-step">
                    <span class="compare-step-number">01</span>
                    <span class="compare-icon">
                      <svg viewBox="0 0 48 48" aria-hidden="true"><path d="M10 9h28a4 4 0 0 1 4 4v17a4 4 0 0 1-4 4H24l-9 7v-7h-5a4 4 0 0 1-4-4V13a4 4 0 0 1 4-4Z"/><circle cx="18" cy="22" r="1.5"/><circle cx="24" cy="22" r="1.5"/><circle cx="30" cy="22" r="1.5"/></svg>
                    </span>
                    <strong>Guest complaint</strong>
                  </div>
                  <div class="compare-step">
                    <span class="compare-step-number">02</span>
                    <span class="compare-icon">
                      <svg viewBox="0 0 48 48" aria-hidden="true"><path d="m8 15 16-8 16 8-16 8-16-8Z"/><path d="m8 24 16 8 16-8M8 33l16 8 16-8"/></svg>
                    </span>
                    <strong>Classification</strong>
                  </div>
                  <div class="compare-step">
                    <span class="compare-step-number">03</span>
                    <span class="compare-icon">
                      <svg viewBox="0 0 48 48" aria-hidden="true"><ellipse cx="20" cy="11" rx="12" ry="5"/><path d="M8 11v18c0 3 5 5 12 5M32 11v10"/><ellipse cx="34" cy="31" rx="8" ry="8"/><path d="m40 37 5 5"/></svg>
                    </span>
                    <strong>RAG evidence</strong>
                  </div>
                  <div class="compare-step">
                    <span class="compare-step-number">04</span>
                    <span class="compare-icon">
                      <svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="24" cy="24" r="17"/><path d="m16 24 5 5 11-12"/></svg>
                    </span>
                    <strong>Clear action</strong>
                  </div>
                </div>

                <div class="compare-points">
                  <div class="point"><i>✓</i><span>Retrieves trusted operational knowledge</span></div>
                  <div class="point"><i>✓</i><span>Grounds troubleshooting and preventive actions</span></div>
                  <div class="point"><i>✓</i><span>Supports faster technician response</span></div>
                </div>
              </article>
            </div>

            <div class="comparison-summary">
              <div class="summary-pill"><span>✓</span>More reliable</div>
              <div class="summary-pill"><span>✓</span>Explainable</div>
              <div class="summary-pill"><span>✓</span>Actionable</div>
              <div class="summary-pill"><span>✓</span>Human governed</div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section
    class="content-section technology-section smartops-rag-section"
    id="technology"
    data-section="technology">

    <div class="section-heading reveal">

        <span class="section-number">
            05
        </span>

        <div>

            <div class="section-kicker">
                Explore the RAG-LLM Engine
            </div>

            <h2>
                The RAG-LLM Intelligence Behind SmartOps AI
            </h2>

            <p>
                See how SmartOps AI uses RAG-LLM to retrieve maintenance knowledge,
                generate grounded recommendations, and support human-governed
                operational decisions.
            </p>

        </div>

    </div>


    <!-- =========================================================
         EXECUTIVE INTRODUCTION
    ========================================================== -->

    <div class="rag-executive-intro reveal">

        <div class="rag-executive-copy">

            <span class="rag-small-label">
                GOVERNED RAG-LLM
            </span>

            <h3>
                Evidence controls generation.
                Governance controls release.
            </h3>

            <p>
                SmartOps does not allow an LLM to answer directly from a
                complaint. The system first retrieves maintenance evidence,
                checks whether that evidence is reliable, generates a
                constrained recommendation and applies deterministic
                governance before the output enters operations.
            </p>

            <div class="rag-executive-points">

                <span>
                    <i>01</i>
                    Scenario-level knowledge
                </span>

                <span>
                    <i>02</i>
                    Confidence-controlled generation
                </span>

                <span>
                    <i>03</i>
                    Human-governed release
                </span>

            </div>

        </div>


        <div class="rag-executive-visual">

            <div class="rag-visual-grid" aria-hidden="true"></div>

            <div class="rag-core-orbit">

                <span class="rag-orbit-label top">
                    RETRIEVE
                </span>

                <span class="rag-orbit-label right">
                    GENERATE
                </span>

                <span class="rag-orbit-label bottom">
                    GOVERN
                </span>

                <span class="rag-orbit-label left">
                    ROUTE
                </span>

                <div class="rag-core-circle">

                    <small>
                        SMARTOPS
                    </small>

                    <strong>
                        RAG
                    </strong>

                    <b>
                        LLM
                    </b>

                </div>

            </div>

        </div>

    </div>


    <!-- =========================================================
         SIX STAGE NAVIGATION
    ========================================================== -->

    <div class="rag-stage-header reveal">

        <div>

            <span>
                CONTROLLED PIPELINE
            </span>

            <h3>
                Seven technical chapters
            </h3>

        </div>

        <p>
            Select a chapter to explore the architecture,
            logic and real maintenance example.
        </p>

    </div>


    <!-- =========================================================
         FRAMEWORK / VALIDATION TABS
    ========================================================== -->

    <div
        class="tech-tabs rag-main-tabs reveal"
        role="tablist"
        aria-label="RAG-LLM presentation content">

        <button
            class="tech-tab active"
            type="button"
            role="tab"
            aria-selected="true"
            data-tab="framework">

            RAG-LLM Framework

        </button>

        <button
            class="tech-tab"
            type="button"
            role="tab"
            aria-selected="false"
            data-tab="validation">

            Validation & Experiments

        </button>
    </div>


    <nav class="rag-stage-navigation reveal" aria-label="RAG-LLM pipeline navigation">

        <div class="rag-nav-group active expanded" data-rag-nav-group="1">
            <button class="rag-stage-button rag-stage-parent active"
                    type="button"
                    data-rag-chapter-button="0"
                    aria-expanded="true">
                <span class="stage-index">01</span>
                <span class="stage-copy">
                    <strong>Intake &amp; Routing</strong>
                    <em>Complaint understanding</em>
                </span>
                <span class="stage-chevron" aria-hidden="true"></span>
            </button>

            <div class="rag-subnav" aria-label="Intake and routing subchapters">
                <button class="rag-subnav-button active"
                        type="button"
                        data-rag-subchapter-button="1A"
                        data-rag-chapter-target="0"
                        data-rag-anchor="classification-model-section">
                    <span>1A</span>
                    <span><strong>Classification Model</strong><em>TF-IDF + Logistic Regression</em></span>
                </button>
                <button class="rag-subnav-button"
                        type="button"
                        data-rag-subchapter-button="1B"
                        data-rag-chapter-target="0"
                        data-rag-anchor="routing-category-section">
                    <span>1B</span>
                    <span><strong>Routing Categories</strong><em>D10–D50 + Other</em></span>
                </button>
            </div>
        </div>

        <div class="rag-nav-group" data-rag-nav-group="2">
            <button class="rag-stage-button rag-stage-parent"
                    type="button"
                    data-rag-chapter-button="1"
                    aria-expanded="false">
                <span class="stage-index">02</span>
                <span class="stage-copy">
                    <strong>Knowledge &amp; Retrieval</strong>
                    <em>Knowledge preparation + live RAG</em>
                </span>
                <span class="stage-chevron" aria-hidden="true"></span>
            </button>

            <div class="rag-subnav" aria-label="Knowledge and retrieval subchapters">
                <button class="rag-subnav-button"
                        type="button"
                        data-rag-subchapter-button="2A"
                        data-rag-chapter-target="1"
                        data-rag-anchor="knowledge-preparation-section">
                    <span>2A</span>
                    <span><strong>Knowledge Preparation</strong><em>Sources → ChromaDB</em></span>
                </button>
                <button class="rag-subnav-button"
                        type="button"
                        data-rag-subchapter-button="2B"
                        data-rag-chapter-target="1"
                        data-rag-anchor="parent-child-section">
                    <span>2B</span>
                    <span><strong>Parent–Child Method</strong><em>Scenario + linked evidence</em></span>
                </button>
                <button class="rag-subnav-button"
                        type="button"
                        data-rag-subchapter-button="2C"
                        data-rag-chapter-target="1"
                        data-rag-anchor="hybrid-retrieval-section">
                    <span>2C</span>
                    <span><strong>Hybrid Retrieval</strong><em>Dense + BM25 + MiniLM</em></span>
                </button>
            </div>
        </div>

        <button class="rag-stage-button"
                type="button"
                data-rag-chapter-button="3">
            <span class="stage-index">03</span>
            <span class="stage-copy"><strong>Gate 1</strong><em>Before the LLM</em></span>
        </button>
        <div class="rag-nav-group" data-rag-nav-group="4">
            <button class="rag-stage-button rag-stage-parent"
                    type="button"
                    data-rag-chapter-button="4"
                    aria-expanded="false">
                <span class="stage-index">04</span>
                <span class="stage-copy"><strong>LLM Generation</strong><em>Engineered LLM system</em></span>
                <span class="stage-chevron" aria-hidden="true"></span>
            </button>

            <div class="rag-subnav" aria-label="LLM generation subchapters">
                <button class="rag-subnav-button"
                        type="button"
                        data-rag-subchapter-button="4A"
                        data-rag-chapter-target="4"
                        data-rag-anchor="llm-generation-4a">
                    <span>4A</span>
                    <span><strong>Grounded Prompting</strong><em>Main inputs → model → structured output</em></span>
                </button>
                <button class="rag-subnav-button"
                        type="button"
                        data-rag-subchapter-button="4B"
                        data-rag-chapter-target="4"
                        data-rag-anchor="llm-generation-4b">
                    <span>4B</span>
                    <span><strong>Engineered Controls</strong><em>Harness-controlled LLM engineering</em></span>
                </button>
            </div>
        </div>

        <button class="rag-stage-button"
                type="button"
                data-rag-chapter-button="5">
            <span class="stage-index">05</span>
            <span class="stage-copy"><strong>Gate 2</strong><em>Operational control</em></span>
        </button>

        <button class="rag-stage-button"
                type="button"
                data-rag-chapter-button="6">
            <span class="stage-index">06</span>
            <span class="stage-copy"><strong>Complete System</strong><em>End-to-end governed pipeline</em></span>
        </button>

    </nav>


    <!-- =========================================================
         FRAMEWORK PANEL
    ========================================================== -->

    <div
        class="tech-panel active rag-framework-panel"
        id="frameworkPanel"
        data-panel="framework">


        <!-- =====================================================
             CHAPTER 01
        ====================================================== -->

        <article class="rag-chapter intake-chapter active" data-rag-chapter="0">
              <section class="intake-model-section" id="classification-model-section" aria-labelledby="classification-model-title">
                <div class="model-section-head">
                  <div class="model-section-copy">
                    <span class="chapter-tag">CHAPTER 01A · CLASSIFICATION MODEL</span>
                    <h3 id="classification-model-title">How SmartOps AI understands each incoming complaint</h3>
                    <p>Maintenance complaints arrive through WhatsApp as natural-language sentences. Before retrieval begins, SmartOps AI converts the text into weighted numerical features and predicts the most relevant maintenance domain.</p>
                  </div>
                  <div class="model-side-stack">
                    <aside class="complaint-example-card" aria-label="Complaint example for Room 305">
                      <span>COMPLAINT EXAMPLE</span>
                      <strong>Room 305</strong>
                      <p>The air conditioner is leaking water.</p>
                      <small>D30 HVAC</small>
                    </aside>
                    <div class="model-status-strip" aria-label="Classification model overview">
                      <span><i></i> SUPERVISED CLASSIFIER</span>
                      <strong>TF-IDF + Logistic Regression</strong>
                      <small>Text classification before RAG retrieval</small>
                    </div>
                  </div>
                </div>

                <div class="classifier-architecture" aria-label="Complaint classification architecture">
                  <article class="architecture-node source-node">
                    <div class="node-topline"><span>01</span><small>INPUT CHANNEL</small></div>
                    <div class="node-visual whatsapp-tech-icon" aria-hidden="true">
                      <svg viewBox="0 0 64 64" role="img" aria-label="WhatsApp">
                        <path class="wa-bubble" d="M32 6C18.2 6 7 16.7 7 29.9c0 4.4 1.3 8.7 3.7 12.4L7.6 57l15.3-3.9c2.9 1.5 6 2.3 9.1 2.3 13.8 0 25-10.7 25-23.9S45.8 6 32 6Z"/>
                        <path class="wa-phone" d="M21.2 17.5h2.2c1.1 0 2 .7 2.3 1.7l1.8 5.4c.3.9 0 1.9-.7 2.5l-2.1 1.8c2.4 4.5 6 8.1 10.5 10.5l1.8-2.1c.6-.7 1.6-1 2.5-.7l5.4 1.8c1 .3 1.7 1.2 1.7 2.3v2.2c0 1.6-1.2 2.9-2.8 3.1-13.7 1.5-25.3-10.1-23.8-23.8.3-1.5 1.6-2.7 3.2-2.7Z"/>
                      </svg>
                    </div>
                    <div class="node-copy"><strong>WhatsApp Complaint Intake</strong></div>
                  </article>

                  <div class="architecture-link" aria-hidden="true"><span></span><i>01</i><b>→</b></div>

                  <article class="architecture-node model-combined-node">
                    <div class="node-topline"><span>02</span><small>CLASSIFICATION MODEL</small></div>
                    <div class="model-combined-visual" aria-hidden="true">
                      <div class="feature-matrix">
                        <span style="--v:.85"></span><span style="--v:.25"></span><span style="--v:.62"></span><span style="--v:.38"></span><span style="--v:.92"></span>
                        <span style="--v:.18"></span><span style="--v:.72"></span><span style="--v:.31"></span><span style="--v:.81"></span><span style="--v:.47"></span>
                        <span style="--v:.58"></span><span style="--v:.14"></span><span style="--v:.76"></span><span style="--v:.42"></span><span style="--v:.68"></span>
                      </div>
                      <span class="model-operator">+</span>
                      <div class="classifier-core">
                        <svg viewBox="0 0 80 80"><circle cx="40" cy="40" r="22"/><circle cx="40" cy="40" r="8"/><path d="M40 8v10M40 62v10M8 40h10M62 40h10M17 17l8 8M55 55l8 8M63 17l-8 8M25 55l-8 8"/></svg>
                        <span>LR</span>
                      </div>
                    </div>
                    <div class="node-copy"><strong>TF-IDF + Logistic Regression</strong></div>
                    
                  </article>

                  <div class="architecture-link" aria-hidden="true"><span></span><i>02</i><b>→</b></div>

                  <article class="architecture-node output-node">
                    <div class="node-topline"><span>03</span><small>ROUTING OUTPUT</small></div>
                    <div class="output-orbit" aria-hidden="true"><span>D10</span><span>D20</span><span>D30</span><span>D40</span><span>D50</span><span>OTHER</span><i>CLASS</i></div>
                    <div class="node-copy"><strong>Predicted Maintenance Domain</strong></div>
                    
                  </article>
                </div>

              </section>

              <div class="intake-chapter-divider" aria-hidden="true"><span></span><i>01B</i><span></span></div>

              <section class="routing-category-section" id="routing-category-section" aria-labelledby="routing-categories-title">
                <div class="routing-section-heading">
                  <div>
                    <span class="chapter-tag">CHAPTER 01B · ROUTING CATEGORIES</span>
                    <h3 id="routing-categories-title">Six routing outcomes organise the knowledge search</h3>
                  </div>
                  <p>SmartOps AI supports five operational maintenance domains. Any complaint outside these domains is assigned to <strong>Other</strong>, preventing unsupported cases from entering the automated retrieval and generation path.</p>
                </div>

                <div class="category-routing-system" aria-label="SmartOps AI maintenance routing categories">
                  <div class="routing-system-core">
                    <div class="core-ring" aria-hidden="true"><span>AI</span><i></i><b></b></div>
                    <div class="router-core-copy">
                      <span class="core-kicker">CLASSIFIER OUTPUT</span>
                      <strong>Category Router</strong>
                      <small>Maps each complaint to one controlled maintenance knowledge domain.</small>
                    </div>
                    <div class="router-domain-count"><span>6</span><small>CONTROLLED<br>OUTPUTS</small></div>
                  </div>

                  <div class="category-grid-tech">
                    <article class="tech-category-card d10">
                      <div class="category-code-block"><span>D10</span><small>DOMAIN 01</small></div>
                      <div class="category-icon-large" aria-hidden="true"><svg viewBox="0 0 72 72"><rect x="17" y="8" width="38" height="56" rx="5"/><path d="M36 15v13M30 22l6 6 6-6M36 57V44M30 50l6-6 6 6M23 34h26M27 40v15M45 40v15"/><circle cx="27" cy="32" r="3"/><circle cx="45" cy="32" r="3"/></svg></div>
                      <div><strong>Conveying</strong><p>Elevators, lifts and movement systems</p></div>
                    </article>

                    <article class="tech-category-card d20">
                      <div class="category-code-block"><span>D20</span><small>DOMAIN 02</small></div>
                      <div class="category-icon-large" aria-hidden="true"><svg viewBox="0 0 72 72"><path d="M10 27h31v13H10zM41 30h9a9 9 0 0 1 9 9v4M24 27V15h25v9M59 43v6M53 49h12M59 53c-5 6-6 10 0 13 6-3 5-7 0-13Z"/></svg></div>
                      <div><strong>Plumbing</strong><p>Leaks, pipes, drainage and water supply</p></div>
                    </article>

                    <article class="tech-category-card d30">
                      <div class="category-code-block"><span>D30</span><small>DOMAIN 03</small></div>
                      <div class="category-icon-large" aria-hidden="true"><svg viewBox="0 0 72 72"><path d="M36 7v58M12 21l48 30M12 51l48-30M36 7l-6 8M36 7l6 8M36 65l-6-8M36 65l6-8M12 21l10 1M12 21l4 9M60 51l-10-1M60 51l-4-9M12 51l10-1M12 51l4-9M60 21l-10 1M60 21l-4 9"/></svg></div>
                      <div><strong>HVAC</strong><p>Air-conditioning, ventilation and cooling</p></div>
                    </article>

                    <article class="tech-category-card d40">
                      <div class="category-code-block"><span>D40</span><small>DOMAIN 04</small></div>
                      <div class="category-icon-large" aria-hidden="true"><svg viewBox="0 0 72 72"><path d="M17 14h38M24 14v13h24V14M36 27v9M19 38h34M21 44v9M30 44v15M42 44v15M51 44v9M20 63h32"/><path d="M17 38c0-7 5-11 10-11h18c6 0 10 4 10 11"/></svg></div>
                      <div><strong>Fire Protection</strong><p>Sprinklers, alarms and fire-safety systems</p></div>
                    </article>

                    <article class="tech-category-card d50">
                      <div class="category-code-block"><span>D50</span><small>DOMAIN 05</small></div>
                      <div class="category-icon-large" aria-hidden="true"><svg viewBox="0 0 72 72"><path d="M42 5 17 41h19l-6 26 25-37H37z"/></svg></div>
                      <div><strong>Electrical</strong><p>Power, sockets, lighting and electrical faults</p></div>
                    </article>

                    <article class="tech-category-card other">
                      <div class="category-code-block"><span>OTHER</span><small>EXCEPTION</small></div>
                      <div class="category-icon-large" aria-hidden="true"><svg viewBox="0 0 72 72"><circle cx="16" cy="36" r="5"/><circle cx="36" cy="36" r="5"/><circle cx="56" cy="36" r="5"/></svg></div>
                      <div><strong>Outside Supported Domains</strong><p>Unmatched cases require controlled human review</p></div>
                    </article>
                  </div>
                </div>

                <div class="routing-policy-grid">
                  <article class="routing-policy supported">
                    <span class="policy-icon" aria-hidden="true">✓</span>
                    <div><small>SUPPORTED MAINTENANCE DOMAIN</small><strong>D10–D50 → Category-filtered RAG</strong><p>The predicted category limits retrieval to the corresponding operational knowledge collection.</p></div>
                    <b>PROCEED</b>
                  </article>
                  <article class="routing-policy unsupported">
                    <span class="policy-icon" aria-hidden="true">×</span>
                    <div><small>UNSUPPORTED OR UNMATCHED DOMAIN</small><strong>Other → OUT_OF_KB → Human review</strong><p>Retrieval and LLM generation are bypassed to avoid unsupported recommendations.</p></div>
                    <b>ESCALATE</b>
                  </article>
                </div>
              </section>
            

            <div class="routing-next-stage-wrap rag-framework-next-wrap">
              <button class="retrieval-ready-compact retrieval-gate-link routing-next-stage-link rag-framework-next-link"
                      type="button"
                      data-rag-next-chapter="1"
                      aria-label="Go to Knowledge Preparation">
                <small>NEXT STAGE</small>
                <strong>Go to Knowledge Preparation</strong>
                <span>Sources, structure, metadata and ChromaDB</span>
              </button>
            </div>

        </article>

        <article
            class="rag-chapter"
            data-rag-chapter="1">

            <section class="knowledge-preparation-section knowledge-subsection" id="knowledge-preparation-section" aria-labelledby="knowledge-preparation-title">
                <div class="model-section-head knowledge-head-match">
                  <div class="model-section-copy">
                    <span class="chapter-tag">CHAPTER 02A · KNOWLEDGE PREPARATION</span>
                    <h3 id="knowledge-preparation-title">Prepare trusted maintenance knowledge for retrieval</h3>
                    <p>SmartOps standardises trusted maintenance references, enriches them with controlled scenario metadata and prepares searchable parent vectors in ChromaDB.</p>
                  </div>
                  <div class="knowledge-hero-pill" aria-label="Controlled knowledge pipeline">
                    <span><i></i> CONTROLLED KNOWLEDGE PIPELINE</span>
                  </div>
                </div>

                <div class="kb-compact-explorer" aria-label="Interactive five-stage knowledge preparation flow">
                  <div class="kb-compact-nav" role="tablist" aria-label="Knowledge preparation stages">
                    <button class="kb-compact-card active" type="button" role="tab" aria-selected="true" data-kb-stage="sources" data-kb-target="kb-stage-sources">
                      <span class="kb-compact-number">01</span>
                      <strong>Knowledge Sources</strong>
                      <small>Trusted maintenance references</small>
                    </button>
                    <span class="kb-compact-arrow" aria-hidden="true">→</span>
                    <button class="kb-compact-card" type="button" role="tab" aria-selected="false" data-kb-stage="clean" data-kb-target="kb-stage-clean">
                      <span class="kb-compact-number">02</span>
                      <strong>Clean &amp; Structure</strong>
                      <small>Standardise records and fields</small>
                    </button>
                    <span class="kb-compact-arrow" aria-hidden="true">→</span>
                    <button class="kb-compact-card" type="button" role="tab" aria-selected="false" data-kb-stage="scenario" data-kb-target="kb-stage-scenario">
                      <span class="kb-compact-number">03</span>
                      <strong>Scenarios + Metadata</strong>
                      <small>LLM enrichment + controlled metadata</small>
                    </button>
                    <span class="kb-compact-arrow" aria-hidden="true">→</span>
                    <button class="kb-compact-card" type="button" role="tab" aria-selected="false" data-kb-stage="chunking" data-kb-target="kb-stage-chunking">
                      <span class="kb-compact-number">04</span>
                      <strong>Parent–Child Chunking</strong>
                      <small>Link scenario and procedures</small>
                    </button>
                    <span class="kb-compact-arrow" aria-hidden="true">→</span>
                    <button class="kb-compact-card" type="button" role="tab" aria-selected="false" data-kb-stage="chromadb" data-kb-target="kb-stage-chromadb">
                      <span class="kb-compact-number">05</span>
                      <strong>Store in ChromaDB</strong>
                      <small>Prepare searchable parent vectors</small>
                    </button>
                  </div>

                  <div class="kb-stage-detail-shell">
                    <article class="kb-stage-detail source-detail active" id="kb-stage-sources" role="tabpanel" data-kb-panel="sources">
                      <div class="source-doc-intake" aria-hidden="true">
                        <div class="source-doc-stack compact-stack expanded-fan">
                          <div class="source-doc doc-astm"><small>PDF</small><span>ASTM<br>Standard</span><i></i><i></i><i></i></div>
                          <div class="source-doc doc-trouble"><small>DOCX</small><span>Troubleshooting<br>Guide</span><i></i><i></i><i></i></div>
                          <div class="source-doc doc-prevent"><small>MANUAL</small><span>Preventive<br>Maintenance</span><i></i><i></i><i></i></div>
                          <div class="source-doc doc-sop"><small>PDF</small><span>Technical<br>SOP</span><i></i><i></i><i></i></div>
                        </div>
                      </div>
                      <div class="kb-detail-copy source-detail-copy">
                        <span>STAGE 01 · SOURCE LAYER</span>
                        <h4>Collect trusted maintenance knowledge</h4>
                        <p>SmartOps AI begins with authoritative maintenance documents rather than relying on the LLM's internal memory. Multiple source formats are collected as the verified foundation of the knowledge base.</p>
                        <div class="source-collection-grid">
                          <div class="source-collect-card"><em>PDF</em><strong>ASTM Standards</strong><small>Authoritative maintenance standards</small></div>
                          <div class="source-collect-card"><em>GUIDE</em><strong>Troubleshooting Guides</strong><small>Issue diagnosis and corrective actions</small></div>
                          <div class="source-collect-card"><em>PM</em><strong>Preventive Maintenance Procedures</strong><small>Routine checks and preventive steps</small></div>
                          <div class="source-collect-card"><em>SOP</em><strong>Technical Manuals &amp; SOPs</strong><small>Structured operating procedures and manuals</small></div>
                        </div>
                      </div>
                      <div class="kb-detail-result source-result">
                        <small>VERIFIED OUTPUT</small>
                        <strong>Trusted Maintenance Source Set</strong>
                        <p>Ready for cleaning and structural standardisation.</p>
                      </div>
                    </article>

                    <article class="kb-stage-detail structure2-detail" id="kb-stage-clean" role="tabpanel" data-kb-panel="clean">
                      <section class="structure2-raw" aria-label="Examples of inconsistent raw maintenance records">
                        <span class="structure2-label">RAW RECORDS</span>
                        <div class="structure2-raw-stack">
                          <article><small>RECORD A</small><strong>Aircon leaking water</strong><p>Asset: Room AC</p></article>
                          <article><small>RECORD B</small><strong>Water dripping from AC unit</strong><p>Equipment: AC unit</p></article>
                          <article><small>RECORD C</small><strong>Water pooling below air-conditioner</strong><p>Issue: Condensate leakage</p></article>
                        </div>
                        <div class="structure2-warning-list">
                          <span>Mixed terminology</span>
                          <span>Different field names</span>
                          <span>Unstructured phrases</span>
                        </div>
                      </section>

                      <section class="structure2-core">
                        <span>STAGE 02 · STRUCTURE LAYER</span>
                        <h4>Standardise maintenance records</h4>
                        <p>Terminology, field names and maintenance descriptions are normalised so the knowledge base follows one consistent structure before scenario development begins.</p>
                        <div class="structure2-process-list">
                          <div><em>01</em><span><strong>Remove noise</strong><small>Discard duplicates and irrelevant content</small></span></div>
                          <div><em>02</em><span><strong>Normalise terminology</strong><small>Aircon / AC unit → Air-conditioning unit</small></span></div>
                          <div><em>03</em><span><strong>Align record fields</strong><small>Use consistent source, asset and issue fields</small></span></div>
                        </div>
                      </section>

                      <aside class="structure2-right-stack">
                        <section class="structure2-standard" aria-label="Example standardised maintenance record">
                          <span class="structure2-label">STANDARDISED RECORD</span>
                          <div><small>ASSET TERM</small><strong>Air-conditioning unit</strong></div>
                          <div><small>ISSUE PHRASE</small><strong>Aircond water leakage</strong></div>
                          <div><small>RECORD TYPE</small><strong>Troubleshooting</strong></div>
                          <div><small>SOURCE</small><strong>HVAC Maintenance Guide</strong></div>
                        </section>

                        <div class="structure2-output">
                          <i aria-hidden="true">✓</i>
                          <div><small>OUTPUT</small><strong>Structured maintenance records</strong><p>Ready for scenario construction and metadata enrichment.</p></div>
                        </div>
                      </aside>
                    </article>

                    <article class="kb-stage-detail scenario3-detail scenario3-wide" id="kb-stage-scenario" role="tabpanel" data-kb-panel="scenario">
                      <section class="scenario3-core">
                        <span>STAGE 03 · LLM METADATA ENRICHMENT</span>
                        <h4>Build the parent scenario and tag metadata</h4>
                        <p>The LLM builds the failure context, then returns controlled metadata through a predefined JSON schema.</p>

                        <div class="scenario3-parts">
                          <article class="scenario3-part">
                            <header><em>PART 01</em><b>LLM SCENARIO ENRICHMENT</b></header>
                            <strong>Build complete failure context for an air-conditioning unit leaking water</strong>
                            <p>The LLM combines related maintenance information into one complete parent scenario so the case context stays clear, structured and retrieval-ready.</p>
                            <div class="scenario3-context-grid compact-context-grid">
                              <span><small>SYMPTOM</small><b>Water dripping from the indoor unit or pooling below the air-conditioner</b></span>
                              <span><small>ROOT CAUSE</small><b>Blocked or overflowing drain pipe causing condensate water leakage</b></span>
                            </div>
                          </article>

                          <article class="scenario3-part metadata-part">
                            <header><em>PART 02</em><b>LLM METADATA TAGGING</b></header>
                            <strong>Return controlled metadata</strong>
                            <p>The LLM fills the required metadata fields while schema validation keeps every value consistent for retrieval and parent–child linking.</p>
                          </article>
                        </div>
                      </section>

                      <aside class="scenario3-right-stack">
                        <section class="scenario3-parent" aria-label="Metadata-enriched parent scenario">
                          <span class="scenario3-label">METADATA-ENRICHED PARENT</span>
                          <div><small>PARENT ID</small><strong>P-D30-001</strong></div>
                          <div><small>MAIN CATEGORY</small><strong>D30 HVAC</strong></div>
                          <div><small>SUB CATEGORY</small><strong>D3030 Cooling Generating Systems</strong></div>
                          <div><small>ISSUE CATEGORY</small><strong>Aircond water leakage</strong></div>
                          <div class="severity-high"><small>SEVERITY</small><strong>High</strong></div>
                          <div><small>SOURCE</small><strong>HVAC Maintenance Guide</strong></div>
                        </section>

                        <div class="scenario3-output">
                          <i aria-hidden="true">✓</i>
                          <div><small>VALIDATED OUTPUT</small><strong>Metadata-Enriched Parent Scenario</strong><p>Ready for parent–child chunking and linked procedure creation.</p></div>
                        </div>
                      </aside>
                    </article>

                    <article class="kb-stage-detail chunk4-detail chunk4-two-column" id="kb-stage-chunking" role="tabpanel" data-kb-panel="chunking">
                      <section class="chunk4-intro" aria-label="Brief explanation of chunking">
                        <span class="chunk4-label">WHAT IS CHUNKING?</span>
                        <h4>Break long knowledge into searchable units</h4>
                        <p>Chunking divides long maintenance documents into smaller units that are easier for retrieval to search.</p>
                        <div class="chunk4-split-visual" aria-hidden="true">
                          <div class="chunk4-long-doc"><i></i><i></i><i></i><i></i></div>
                          <b>→</b>
                          <div class="chunk4-small-units"><span></span><span></span><span></span></div>
                        </div>
                      </section>

                      <section class="chunk4-core">
                        <span>STAGE 04 · PARENT–CHILD CHUNKING</span>
                        <h4>Keep the context, link the details</h4>
                        <p>The parent preserves the complete scenario. Its child chunks store related procedures using the same <code>parent_id</code>.</p>

                        <div class="chunk4-map" aria-label="Parent and child chunk relationship">
                          <div class="chunk4-map-parent">
                            <small>PARENT CHUNK</small>
                            <strong>Aircond water leakage</strong>
                            <p><code>P-D30-001</code> · Complete scenario context</p>
                          </div>
                          <div class="chunk4-map-link"><i></i><b>same parent_id</b><i></i></div>
                          <div class="chunk4-map-children">
                            <div><small>CHILD 01</small><strong>Troubleshooting</strong></div>
                            <div><small>CHILD 02</small><strong>Preventive Maintenance</strong></div>
                          </div>
                        </div>

                        <div class="chunk4-output chunk4-output-inline">
                          <i aria-hidden="true">✓</i>
                          <div><small>OUTPUT</small><strong>1 Parent + 2 Linked Children</strong><p>Ready for parent embedding and ChromaDB storage.</p></div>
                        </div>
                      </section>
                    </article>

                    <article class="kb-stage-detail stage5-detail" id="kb-stage-chromadb" role="tabpanel" data-kb-panel="chromadb">
                      <section class="stage5-core">
                        <span>STAGE 05 · EMBEDDING &amp; VECTOR STORE</span>
                        <h4>Convert maintenance text into a searchable vector</h4>
                        <p>Embedding converts maintenance text into numerical vectors that capture its semantic meaning, making similar issues easier to retrieve.</p>

                        <div class="stage5-flow stage5-flow-two" aria-label="Embedding model to vector output flow">
                          <div class="stage5-flow-card model-card">
                            <small>01 · EMBEDDING MODEL</small>
                            <strong>BAAI/bge-small-en-v1.5</strong>
                            <span>Encodes maintenance meaning into a numerical representation</span>
                          </div>
                          <i class="stage5-arrow" aria-hidden="true">→</i>
                          <div class="stage5-flow-card vector-card">
                            <small>02 · VECTOR OUTPUT</small>
                            <strong>[ 0.23, −0.12, 0.45, … ]</strong>
                            <span>Searchable semantic vector</span>
                          </div>
                        </div>

                        <div class="stage5-key-note"><i>◎</i><strong>Similar meanings are stored closer together in vector space.</strong></div>
                      </section>

                      <aside class="stage5-right-stack">
                        <section class="stage5-store" aria-label="ChromaDB vector storage">
                          <span class="stage5-label">STORE IN CHROMADB</span>
                          <div class="stage5-db-brand stage5-db-brand-image">
                            <img src="assets/logos/chromadb-official-logo.png" alt="ChromaDB logo">
                          </div>
                          <div class="stage5-store-row"><small>VECTOR</small><strong>Semantic embedding vector</strong></div>
                          <div class="stage5-store-row"><small>METADATA</small><strong>D30 HVAC · Aircond water leakage · High</strong></div>
                          <div class="stage5-store-row"><small>INDEX</small><strong>Stored for semantic similarity search</strong></div>
                        </section>

                        <div class="stage5-output">
                          <i aria-hidden="true">✓</i>
                          <div><small>OUTPUT</small><strong>Retrieval-Ready Knowledge Base</strong><p>Ready for semantic search and linked evidence retrieval.</p></div>
                        </div>
                      </aside>
                    </article>
                  </div>

                  <div class="retrieval-literature-bar knowledge-literature-bar" aria-label="Literature basis for knowledge preparation">
                    <small>LITERATURE BASIS</small>
                    <span class="retrieval-literature-chip">Ludwig, Schmidt and Kühn (2025)</span>
                    <p>Uses ontology traversal, classical matching and vector retrieval to enrich maintenance context.</p>
                  </div>

                  <div class="knowledge-transform-callout">
                    <div class="transform-spark" aria-hidden="true"><span>✦</span></div>
                    <p><strong>Knowledge is not sent directly to the model.</strong> It is first transformed into a structured, <b>retrieval-ready format</b>.</p>
                  </div>
                </div>
              </section>

              <div class="knowledge-section-divider" aria-hidden="true"><span></span><i>02B</i><span></span></div>

              

            <div class="rag-chapter-heading rag-subchapter-heading" id="parent-child-section">

                <div>
                    <span class="rag-chapter-code">CHAPTER 02B · PARENT–CHILD METHOD</span>
                    <h3>Preserve one complete maintenance scenario</h3>
                    <p>
                        SmartOps stores one parent scenario together with linked
                        troubleshooting and preventive children. Only the parent
                        is indexed. Its children are attached after selection.
                    </p>
                </div>

                <div class="rag-chapter-status">
                    <span></span>
                    SCENARIO-LEVEL KNOWLEDGE
                </div>

            </div>


            <div class="rag-chapter-grid">


                <div class="rag-content-card">

                    <div class="rag-card-label">
                        PROJECT UNIQUENESS
                    </div>

                    <h4>
                        Parent-child knowledge structure
                    </h4>

                    <p>
                        Instead of retrieving isolated instructions,
                        the pipeline retrieves the complete maintenance
                        scenario and reconstructs its supporting evidence.
                    </p>


                    <div class="rag-feature-stack">

                        <div>

                            <i>
                                P
                            </i>

                            <span>

                                <strong>
                                    Parent scenario
                                </strong>

                                <small>
                                    Scenario identity, category, problem,
                                    symptom and failure context.
                                </small>

                            </span>

                        </div>


                        <div>

                            <i>
                                T
                            </i>

                            <span>

                                <strong>
                                    Troubleshooting child
                                </strong>

                                <small>
                                    Corrective inspection and maintenance evidence.
                                </small>

                            </span>

                        </div>


                        <div>

                            <i>
                                T
                            </i>

                            <span>

                                <strong>
                                    Preventive child
                                </strong>

                                <small>
                                    Preventive maintenance evidence.
                                </small>

                            </span>

                        </div>

                    </div>


                    <button
                        class="rag-business-button"
                        type="button"
                        data-rag-modal-open="kbExampleModal">

                        View Knowledge Base Example

                        <span>
                            ↗
                        </span>

                    </button>

                </div>


                <div class="rag-system-card">

                    <div class="rag-parent-child-architecture">

                        <div class="rag-parent-card">

                            <small>
                                INDEXED PARENT
                            </small>

                            <strong>
                                Indoor AC Water Leakage
                            </strong>

                            <span>
                                Scenario ID · D30 HVAC · problem · symptom
                            </span>

                        </div>


                        <div class="rag-link-line">

                            <span></span>

                            <b>
                                scenario_id
                            </b>

                            <span></span>

                        </div>


                        <div class="rag-child-row">

                            <div class="rag-child-card troubleshooting">

                                <small>
                                    LINKED CHILD
                                </small>

                                <strong>
                                    Troubleshooting
                                </strong>

                                <span>
                                    Corrective evidence
                                </span>

                            </div>


                            <div class="rag-child-card preventive">

                                <small>
                                    LINKED CHILD
                                </small>

                                <strong>
                                    Preventive
                                </strong>

                                <span>
                                    Preventive evidence
                                </span>

                            </div>

                        </div>


                        <div class="rag-indexing-rule">

                            <span>
                                01
                            </span>

                            <strong>
                                Embed parent
                            </strong>

                            <b>
                                →
                            </b>

                            <span>
                                02
                            </span>

                            <strong>
                                Select parent
                            </strong>

                            <b>
                                →
                            </b>

                            <span>
                                03
                            </span>

                            <strong>
                                Attach children
                            </strong>

                        </div>

                    </div>

                </div>


            </div>

        

            <div class="rag-chapter-heading rag-subchapter-heading" id="hybrid-retrieval-section">

                <div>

                    <span class="rag-chapter-code">
                        CHAPTER 02C · HYBRID RETRIEVAL
                    </span>

                    <h3>
                        Retrieve and rerank the strongest scenario
                    </h3>

                    <p>
                        Category-constrained dense and sparse retrieval
                        produce candidate parents. Weighted fusion combines
                        both retrieval signals into a Top-10 parent candidate
                        pool. MiniLM reranks those candidates and retains the
                        final Top-5 scenarios.
                    </p>

                </div>

                <div class="rag-chapter-status">
                    <span></span>
                    HYBRID RETRIEVAL
                </div>

            </div>


            <div class="rag-retrieval-board">


                <div class="rag-retrieval-node category">

                    <small>
                        01 · FILTER
                    </small>

                    <strong>
                        D30 HVAC
                    </strong>

                    <span>
                        Search one maintenance domain
                    </span>

                </div>


                <div class="rag-flow-arrow">
                    →
                </div>


                <div class="rag-parallel-search">

                    <div>

                        <small>
                            DENSE
                        </small>

                        <strong>
                            BGE-small
                        </strong>

                        <span>
                            Semantic similarity
                        </span>

                    </div>


                    <div>

                        <small>
                            SPARSE
                        </small>

                        <strong>
                            BM25
                        </strong>

                        <span>
                            Keyword relevance
                        </span>

                    </div>

                </div>


                <div class="rag-flow-arrow">
                    →
                </div>


                <div class="rag-retrieval-node fusion">

                    <small>
                        02 · FUSION
                    </small>

                    <strong>
                        0.40 / 0.60
                    </strong>

                    <span>
                        Dense and sparse scores
                    </span>

                </div>


                <div class="rag-flow-arrow">
                    →
                </div>


                <div class="rag-retrieval-node candidates">

                    <small>
                        03 · CANDIDATES
                    </small>

                    <strong>
                        Top-10
                    </strong>

                    <span>
                        Hybrid parent candidates
                    </span>

                </div>


                <div class="rag-flow-arrow">
                    →
                </div>


                <div class="rag-retrieval-node rerank">

                    <small>
                        04 · RERANK
                    </small>

                    <strong>
                        MiniLM
                    </strong>

                    <span>
                        Top-10 &rarr; final Top-5
                    </span>

                </div>


            </div>


            <div class="rag-selected-result">

                <div>

                    <small>
                        SELECTED PARENT SCENARIO
                    </small>

                    <strong>
                        Indoor AC Water Leakage
                    </strong>

                    <span>
                        Parent scenario + linked troubleshooting and preventive context
                    </span>

                </div>


                <button
                    class="rag-business-button"
                    type="button"
                    data-rag-modal-open="retrievalExampleModal">

                    View Top-5 Retrieval Example

                    <span>
                        ↗
                    </span>

                </button>

            </div>

        

            <div class="routing-next-stage-wrap rag-framework-next-wrap">
              <button class="retrieval-ready-compact retrieval-gate-link routing-next-stage-link rag-framework-next-link"
                      type="button"
                      data-rag-next-chapter="3"
                      aria-label="Go to Gate 1">
                <small>NEXT STAGE</small>
                <strong>Go to Gate 1</strong>
                <span>Confidence control before generation</span>
              </button>
            </div>

        </article>


        <!-- =====================================================
             CHAPTER 03
        ====================================================== -->

        <article
            class="rag-chapter rag-gate1-chapter"
            data-rag-chapter="3">

            <div class="rag-gate-simple">

                <div class="rag-gate-simple-copy">

                    <span class="rag-chapter-code">
                        CHAPTER 03 · UNCERTAINTY CONTROL
                    </span>

                    <h3>
                        Gate 1: Is the retrieved evidence reliable enough?
                    </h3>

                    <p>
                        A calibrated retrieval-confidence check controls whether
                        a case can proceed to the LLM. Low-confidence or unsupported
                        cases do not force a generated recommendation.
                    </p>

                    <div class="rag-gate-simple-outcomes">

                        <div class="ready">
                            <strong>RAG_READY</strong>
                            <span>Send grounded context to the LLM</span>
                        </div>

                        <div class="review">
                            <strong>RETRIEVAL_HITL</strong>
                            <span>Hold for human review</span>
                        </div>

                        <div class="blocked">
                            <strong>OUT_OF_KB</strong>
                            <span>Stop unsupported generation</span>
                        </div>

                    </div>

                    <button
                        class="rag-business-button secondary"
                        type="button"
                        data-rag-modal-open="gate1Modal">

                        Learn More About Gate 1

                        <span>↗</span>

                    </button>

                    <p class="rag-gate-simple-note">
                        Gate 1 combines retrieval confidence, category consistency
                        and context completeness before generation.
                    </p>

                </div>

                <div class="rag-gate-simple-visual" aria-label="Gate 1 confidence outcomes">

                    <div class="rag-gauge">

                        <span class="gauge-arc"></span>
                        <span class="gauge-needle"></span>

                        <div>
                            <small>CALIBRATED CONFIDENCE</small>
                            
                        </div>

                    </div>

                    <div class="rag-gate-simple-labels">
                        <span class="ready">RAG READY</span>
                        <span class="review">HUMAN REVIEW</span>
                        <span class="blocked">OUT OF KB</span>
                    </div>

                </div>

            </div>

        

            <div class="routing-next-stage-wrap rag-framework-next-wrap">
              <button class="retrieval-ready-compact retrieval-gate-link routing-next-stage-link rag-framework-next-link"
                      type="button"
                      data-rag-next-chapter="4"
                      aria-label="Go to LLM Generation">
                <small>NEXT STAGE</small>
                <strong>Go to LLM Generation</strong>
                <span>Engineered generation + verification harness</span>
              </button>
            </div>

        </article>




        <!-- =====================================================
             CHAPTER 04 · LLM GENERATION
        ====================================================== -->

        <article
            class="rag-chapter rag-generation-chapter llm-generation-inline"
            data-rag-chapter="4">

            <style>
                .rag-generation-chapter .llm-inline-section{display:block;}
                .rag-generation-chapter .llm4a-flow{display:grid;grid-template-columns:minmax(0,1fr) 30px minmax(240px,.9fr) 30px minmax(0,.98fr);gap:12px;align-items:stretch;}
                .rag-generation-chapter .llm4a-panel{padding:20px 20px 18px;border:1px solid #d6e5f3;border-radius:28px;background:#fcfeff;overflow:hidden;}
                .rag-generation-chapter .llm4a-input-panel{border-top:5px solid #2c68ff;}
                .rag-generation-chapter .llm4a-model-panel{border-top:5px solid #8558de;display:flex;flex-direction:column;align-items:center;}
                .rag-generation-chapter .llm4a-output-panel{border-top:5px solid #2bb8aa;background:#f8fffd;}
                .rag-generation-chapter .llm4a-panel small{display:block;margin-bottom:12px;font-size:11px;font-weight:900;letter-spacing:.13em;}
                .rag-generation-chapter .llm4a-input-panel small{color:#2d69f0;}
                .rag-generation-chapter .llm4a-model-panel small{color:#8257d9;text-align:center;}
                .rag-generation-chapter .llm4a-output-panel small{color:#138c83;}
                .rag-generation-chapter .llm4a-panel h4{margin:0 0 20px;color:#173552;font-size:22px;line-height:1.12;letter-spacing:-.03em;}
                .rag-generation-chapter .llm4a-input-list{display:grid;gap:10px;}
                .rag-generation-chapter .llm4a-input-list > div{min-height:56px;display:flex;align-items:center;padding:0 16px;border:1px solid #d7e5f2;border-radius:20px;background:#f9fcff;color:#16385b;font-size:17px;font-weight:850;line-height:1.15;}
                .rag-generation-chapter .llm4a-frozen-prompt{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-top:10px;padding:12px 14px;border:1px solid #bdd7f7;border-radius:18px;background:linear-gradient(90deg,#eef6ff 0%,#f4fffc 100%);}
                .rag-generation-chapter .llm4a-frozen-prompt strong{font-size:15px;line-height:1.15;color:#2064d9;}
                .rag-generation-chapter .llm4a-frozen-prompt span{font-size:12px;line-height:1.35;color:#6a8098;text-align:right;}
                .rag-generation-chapter .llm4a-arrow{display:grid;place-items:center;color:#f0a02b;font-size:36px;font-weight:950;align-self:center;}
                .rag-generation-chapter .llm4a-model-tile{width:100%;max-width:280px;min-height:240px;margin:4px auto 14px;padding:18px;border-radius:32px;background:linear-gradient(145deg,#7759df 0%,#533bc0 100%);display:flex;flex-direction:column;justify-content:center;align-items:center;gap:18px;box-shadow:0 20px 36px rgba(97,70,201,.20);}
                .rag-generation-chapter .llm4a-groq-brand{display:flex;align-items:center;gap:12px;justify-content:center;}
                .rag-generation-chapter .llm4a-groq-brand img{width:44px;height:44px;object-fit:contain;border-radius:12px;background:#fff;}
                .rag-generation-chapter .llm4a-groq-brand strong{font-size:18px;color:#fff;}
                .rag-generation-chapter .llm4a-model-name{color:#fff;font-size:24px;font-weight:950;line-height:1.08;text-align:center;}
                .rag-generation-chapter .llm4a-model-name span{display:block;margin-top:8px;color:#e5ddff;font-size:12px;letter-spacing:.15em;text-transform:uppercase;}
                .rag-generation-chapter .llm4a-model-panel p{margin:0 auto;max-width:250px;text-align:center;color:#6a7d95;font-size:12px;line-height:1.45;}
                .rag-generation-chapter .llm4a-output-panel pre{margin:0;padding:16px;border-radius:22px;background:linear-gradient(145deg,#082749 0%,#08395a 100%);color:#dff8ff;min-height:330px;overflow:auto;white-space:pre;word-break:normal;font:11px/1.45 Consolas,"Courier New",monospace;}
                .rag-generation-chapter .llm4a-controls{margin-top:16px;padding:16px;border:1px solid #d7e5f2;border-radius:22px;background:#fff;}
                .rag-generation-chapter .llm4a-controls-title{display:flex;align-items:center;gap:12px;color:#266dff;font-size:14px;font-weight:950;letter-spacing:.11em;text-transform:uppercase;}
                .rag-generation-chapter .llm4a-controls-title i{width:28px;height:3px;border-radius:99px;background:#266dff;display:inline-block;}
                .rag-generation-chapter .llm4a-control-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:12px;}
                .rag-generation-chapter .llm4a-control-grid article{min-height:84px;display:grid;grid-template-columns:46px 1fr;align-items:flex-start;gap:10px;padding:16px;border:1px solid #d5e3f1;border-radius:16px;background:#fff;}
                .rag-generation-chapter .llm4a-control-grid b{width:36px;height:36px;border-radius:12px;display:grid;place-items:center;font-size:11px;font-weight:900;color:#236cff;background:#eef5ff;}
                .rag-generation-chapter .llm4a-control-grid strong{display:block;font-size:15px;line-height:1.25;color:#173754;}
                .rag-generation-chapter .llm4a-control-grid span{display:block;margin-top:4px;font-size:12px;line-height:1.4;color:#7388a1;}
                .rag-generation-chapter .llm4a-prompt-button-row{display:flex;justify-content:flex-end;margin-top:10px;}
                @media (max-width: 1250px){
                  .rag-generation-chapter .llm4a-flow{grid-template-columns:1fr;}
                  .rag-generation-chapter .llm4a-arrow{transform:rotate(90deg);font-size:42px;}
                }
            </style>

            <section class="llm-inline-section llm-inline-4a" id="llm-generation-4a">

                <div class="rag-chapter-heading llm-inline-heading">
                    <div>
                        <span class="rag-chapter-code">CHAPTER 04A · GROUNDED GENERATION</span>
                        <h3>Grounded Structured Prompting</h3>
                        <p>Frozen Prompt V1 combines the complaint and selected maintenance evidence, constrains the LLM and returns one predictable JSON recommendation.</p>
                    </div>
                    <div class="rag-chapter-status"><span></span> GROQ · LLAMA 3.1 8B INSTANT</div>
                </div>

                <div class="llm4a-flow-label"><i></i> MAIN INPUTS → LLM MODEL → STRUCTURED OUTPUT</div>

                <div class="llm4a-flow">
                    <article class="llm4a-panel llm4a-input-panel">
                        <small>01 · MAIN INPUTS</small>
                        <h4>Controlled evidence package</h4>
                        <div class="llm4a-input-list">
                            <div>Complaint</div>
                            <div>Parent Scenario</div>
                            <div>Troubleshooting Child</div>
                            <div>Preventive Child</div>
                        </div>
                        <div class="llm4a-frozen-prompt">
                            <strong>Frozen Prompt V1</strong>
                            <span>Role, evidence-only rules and exact JSON contract</span>
                        </div>
                    </article>

                    <div class="llm4a-arrow" aria-hidden="true">→</div>

                    <article class="llm4a-panel llm4a-model-panel">
                        <small>02 · LLM MODEL</small>
                        <div class="llm4a-model-tile">
                            <div class="llm4a-groq-brand">
                                <img src="llm_generation/groq-logo.ico" alt="Groq logo">
                                <strong>Groq</strong>
                            </div>
                            <div class="llm4a-model-name">Llama 3.1<span>8B INSTANT</span></div>
                        </div>
                        <p>Transforms supplied evidence into cautious, technician-ready guidance.</p>
                    </article>

                    <div class="llm4a-arrow" aria-hidden="true">→</div>

                    <article class="llm4a-panel llm4a-output-panel">
                        <small>03 · OUTPUT</small>
                        <h4>Recommendation JSON</h4>
                        <pre>{
  "scenario_summary": "...",
  "likely_issue": "...",
  "recommended_actions": [],
  "safety_precautions": [],
  "preventive_actions": [],
  "tools_or_materials": [],
  "evidence": [],
  "context_sufficient": true,
  "information_gaps": []
}</pre>
                    </article>
                </div>

                <div class="llm4a-controls">
                    <div class="llm4a-controls-title"><i></i> GROUNDED STRUCTURED PROMPT CONTROLS</div>
                    <div class="llm4a-control-grid">
                        <article><b>01</b><div><strong>Use supplied evidence only</strong><span>No unsupported diagnosis, tool, procedure or action.</span></div></article>
                        <article><b>02</b><div><strong>Use cautious causal language</strong><span>The complaint is a symptom, not proof of root cause.</span></div></article>
                        <article><b>03</b><div><strong>Return one exact JSON schema</strong><span>Required fields and data types stay machine-readable.</span></div></article>
                        <article><b>04</b><div><strong>Keep governance outside the LLM</strong><span>No severity, priority, approval, escalation or assignment decisions.</span></div></article>
                    </div>
                    <div class="llm4a-prompt-button-row">
                        <button class="rag-business-button" type="button" data-rag-modal-open="llmPromptModal">View Full Frozen Prompt V1 <span>↗</span></button>
                    </div>
                </div>

            </section>

            <section class="llm-inline-section llm-inline-4b" id="llm-generation-4b">

                <div class="rag-chapter-heading llm-inline-heading llm-inline-subheading">
                    <div>
                        <span class="rag-chapter-code">CHAPTER 04B · ENGINEERED CONTROLS</span>
                        <h3>Harness-Controlled LLM Engineering</h3>
                        <p>The model is only the centre. SmartOps engineers the system around it to control what enters, what may be produced and what can continue.</p>
                    </div>
                    <div class="rag-chapter-status"><span></span> MODEL + ENGINEERED CONTROLS</div>
                </div>

                <div class="llm4b-grid">
                    <section class="llm4b-stack-panel">
                        <div class="llm4b-panel-head"><h4>The system around the model</h4><span>CONTROL LAYERS</span></div>
                        <div class="llm4b-stack" aria-label="Nested control layers around the LLM model">
                            <div class="llm4b-ring loop"></div>
                            <div class="llm4b-ring harness"></div>
                            <div class="llm4b-ring context"></div>
                            <div class="llm4b-ring prompt"></div>
                            <button class="llm4b-label loop llm4b-control-trigger" type="button" data-llm4b-control="loop" aria-pressed="false">LOOP</button>
                            <button class="llm4b-label harness llm4b-control-trigger" type="button" data-llm4b-control="harness" aria-pressed="false">HARNESS</button>
                            <button class="llm4b-label context llm4b-control-trigger" type="button" data-llm4b-control="context" aria-pressed="false">CONTEXT</button>
                            <button class="llm4b-label prompt llm4b-control-trigger" type="button" data-llm4b-control="prompt" aria-pressed="false">PROMPT</button>
                            <span class="llm4b-description loop">Generate → Verify → Repair → Re-verify</span>
                            <span class="llm4b-description harness">Coordinates generator, verifier, grounding and failure handling</span>
                            <span class="llm4b-description context">Supplies selected and compacted RAG evidence</span>
                            <span class="llm4b-description prompt">Defines role, restrictions and JSON outputs</span>
                            <button class="llm4b-model-core llm4b-control-trigger" type="button" data-llm4b-control="model" aria-pressed="false"><strong>MODEL</strong><span>Groq Llama 3.1<br>8B Instant</span></button>
                        </div>
                    </section>

                    <section class="llm4b-overview-panel">
                        <div class="llm4b-overview-head">
                            <div class="llm4b-overview-title" id="llm4bOverviewTitle">ENGINEERING OVERVIEW</div>
                            <button class="llm4b-overview-back" id="llm4bOverviewBack" type="button" hidden>← Overview</button>
                        </div>

                        <div class="llm4b-overview-list llm4b-control-view active" data-llm4b-view="default">
                            <button type="button" data-llm4b-control="model"><b>01</b><div><strong>Model</strong><span>Generates the technician-ready recommendation.</span></div></button>
                            <button type="button" data-llm4b-control="prompt"><b>02</b><div><strong>Prompt</strong><span>Evidence-only instructions and strict JSON structure.</span></div></button>
                            <button type="button" data-llm4b-control="context"><b>03</b><div><strong>Context</strong><span>Only selected and compacted RAG evidence enters the model.</span></div></button>
                            <button type="button" data-llm4b-control="harness"><b>04</b><div><strong>Harness</strong><span>Generate, verify and ground every response before release.</span></div></button>
                            <button type="button" data-llm4b-control="loop"><b>05</b><div><strong>Loop</strong><span>Bounded repair cycle: pass, repair once or fail closed.</span></div></button>
                        </div>

                        <div class="llm4b-control-view llm4b-detail-view" data-llm4b-view="model">
                            <div class="llm4b-detail-summary output"><small>MODEL CONTROL</small><strong>Output Engineering</strong><p>The LLM generates one predictable recommendation object for the SmartOps workflow.</p></div>
                            <div class="llm4b-detail-points">
                                <article><b>01</b><div><strong>Strict schema</strong><span>Required JSON fields and data types are enforced.</span></div></article>
                                <article><b>02</b><div><strong>Compatible output</strong><span>The response can be consumed by Gate 2 and the frontend adapter.</span></div></article>
                                <article><b>03</b><div><strong>No operational authority</strong><span>The model recommends; deterministic controls decide release.</span></div></article>
                            </div>
                        </div>

                        <div class="llm4b-control-view llm4b-detail-view" data-llm4b-view="prompt">
                            <div class="llm4b-detail-summary prompt"><small>PROMPT CONTROL</small><strong>Prompt Engineering</strong><p>Frozen Prompt V1 defines the role, restrictions and exact response contract.</p></div>
                            <div class="llm4b-detail-points">
                                <article><b>01</b><div><strong>Evidence only</strong><span>No unsupported diagnosis, procedure, tool or action.</span></div></article>
                                <article><b>02</b><div><strong>Cautious language</strong><span>The complaint is treated as a symptom, not proof of root cause.</span></div></article>
                                <article><b>03</b><div><strong>Governance excluded</strong><span>No severity, priority, approval or assignment decisions.</span></div></article>
                            </div>
                        </div>

                        <div class="llm4b-control-view llm4b-detail-view" data-llm4b-view="context">
                            <div class="llm4b-detail-summary context"><small>CONTEXT CONTROL</small><strong>Only relevant evidence enters the model</strong><p>Retrieved knowledge is selected, filtered and compacted before generation.</p></div>
                            <div class="llm4b-mini-flow">
                                <article><b>01</b><div><strong>Guest complaint</strong><span>Original maintenance issue</span></div></article><i>↓</i>
                                <article><b>02</b><div><strong>Category context</strong><span>Predicted maintenance domain</span></div></article><i>↓</i>
                                <article><b>03</b><div><strong>Hybrid retrieval</strong><span>Dense + BM25 evidence</span></div></article><i>↓</i>
                                <article><b>04</b><div><strong>Rerank and select</strong><span>Strongest parent scenario</span></div></article><i>↓</i>
                                <article><b>05</b><div><strong>Compact context</strong><span>Parent + linked children</span></div></article><i>↓</i>
                                <article><b>06</b><div><strong>LLM generation</strong><span>Grounded recommendation JSON</span></div></article>
                            </div>
                        </div>

                        <div class="llm4b-control-view llm4b-detail-view" data-llm4b-view="harness">
                            <div class="llm4b-detail-summary harness"><small>HARNESS CONTROL</small><strong>Generate, verify and ground every response</strong><p>The harness coordinates generation, validation and failure handling.</p></div>
                            <div class="llm4b-mini-flow">
                                <article><b>01</b><div><strong>Gather</strong><span>Prepare grounded RAG evidence</span></div></article><i>↓</i>
                                <article><b>02</b><div><strong>Generate</strong><span>Create structured JSON</span></div></article><i>↓</i>
                                <article><b>03</b><div><strong>Verify JSON</strong><span>Validate schema and fields</span></div></article><i>↓</i>
                                <article><b>04</b><div><strong>Verify claims</strong><span>Check evidence support</span></div></article><i>↓</i>
                                <article><b>05</b><div><strong>Ground</strong><span>Run deterministic pre-check</span></div></article><i>↓</i>
                                <article><b>06</b><div><strong>Output</strong><span>Pass grounded result to Gate 2</span></div></article>
                            </div>
                        </div>

                        <div class="llm4b-control-view llm4b-detail-view" data-llm4b-view="loop">
                            <div class="llm4b-detail-summary loop"><small>BOUNDED REPAIR</small><strong>Pass, repair once or fail closed</strong><p>Unsupported guidance cannot loop indefinitely or enter operations.</p></div>
                            <div class="llm4b-loop-flow">
                                <article><b>01</b><div><strong>Run harness</strong><span>Generate → Verify → Ground</span></div></article>
                                <div class="llm4b-loop-decision"><small>02 · DECISION</small><strong>Supported?</strong></div>
                                <div class="llm4b-loop-branches"><span class="pass">YES · PASS TO GATE 2</span><span class="repair">NO · REPAIR ONCE</span></div>
                                <article><b>03</b><div><strong>Re-verify</strong><span>Run semantic and grounding checks again</span></div></article>
                                <div class="llm4b-loop-branches"><span class="pass">PASS · GROUNDED OUTPUT</span><span class="fail">FAIL · ROUTE TO HITL</span></div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="llm4b-engineering-cards">
                    <article><b>1</b><strong>Prompt Engineering</strong><p>Evidence-only prompts constrain the LLM and prohibit unsupported decisions.</p></article>
                    <article><b>2</b><strong>Context Engineering</strong><p>Retrieved evidence is organized, filtered and compacted before generation.</p></article>
                    <article><b>3</b><strong>Loop Engineering</strong><p>A bounded Generate → Verify → Repair → Re-verify cycle corrects unsupported guidance.</p></article>
                    <article><b>4</b><strong>Output Engineering</strong><p>Strict schema and validation retries produce compatible responses.</p></article>
                </div>

                <div class="llm4b-principle llm4b-principle-results">
                    <b>✓</b>
                    <div><strong>Harness = control + guardrails + verification.</strong> It makes the LLM useful without giving the model uncontrolled operational authority.</div>
                    <button class="rag-business-button llm4b-results-button" type="button" data-rag-modal-open="llmResultsModal">View Main LLM Results <span>↗</span></button>
                </div>

            </section>

            <div class="routing-next-stage-wrap rag-framework-next-wrap">
              <button class="retrieval-ready-compact retrieval-gate-link routing-next-stage-link rag-framework-next-link"
                      type="button"
                      data-rag-next-chapter="5"
                      aria-label="Go to Gate 2">
                <small>NEXT STAGE</small>
                <strong>Go to Gate 2</strong>
                <span>Operational governance, escalation and HITL routing</span>
              </button>
            </div>

        </article>

        <!-- =====================================================
             CHAPTER 05
        ====================================================== -->

        <article
            class="rag-chapter rag-governance-chapter"
            data-rag-chapter="5">

            <div class="rag-chapter-heading">

                <div>

                    <span class="rag-chapter-code">
                        CHAPTER 05
                    </span>

                    <h3>
                        Gate 2: Validate before operational release
                    </h3>

                    <p>
                        Deterministic governance checks decide whether the
                        generated recommendation can be released, requires
                        human review or must be blocked.
                    </p>

                </div>

                <div class="rag-chapter-status">
                    <span></span>
                    OPERATIONAL GOVERNANCE
                </div>

            </div>


            <div class="rag-governance-layout">


                <div class="rag-validation-stack">

                    <div>

                        <span>
                            01
                        </span>

                        <strong>
                            JSON Schema
                        </strong>

                        <i>
                            ✓
                        </i>

                    </div>


                    <div>

                        <span>
                            02
                        </span>

                        <strong>
                            Evidence Grounding
                        </strong>

                        <i>
                            ✓
                        </i>

                    </div>


                    <div>

                        <span>
                            03
                        </span>

                        <strong>
                            Safety Flags
                        </strong>

                        <i>
                            ✓
                        </i>

                    </div>


                    <div>

                        <span>
                            04
                        </span>

                        <strong>
                            Severity and Policy
                        </strong>

                        <i>
                            ✓
                        </i>

                    </div>

                </div>


                <div class="rag-governance-outcomes">

                    <div class="approved">

                        <small>
                            ROUTE 01
                        </small>

                        <strong>
                            AUTO_APPROVED
                        </strong>

                        <span>
                            Recommendation may enter the operational queue.
                        </span>

                    </div>


                    <div class="review">

                        <small>
                            ROUTE 02
                        </small>

                        <strong>
                            HUMAN_REVIEW
                        </strong>

                        <span>
                            Manager approval is required before release.
                        </span>

                    </div>


                    <div class="blocked">

                        <small>
                            ROUTE 03
                        </small>

                        <strong>
                            RELEASE_BLOCKED
                        </strong>

                        <span>
                            The recommendation cannot enter operations.
                        </span>

                    </div>

                </div>


            </div>


            <div class="rag-action-bar">

                <div>

                    <small>
                        GOVERNANCE PRINCIPLE
                    </small>

                    <strong>
                        The LLM recommends. SmartOps controls authority.
                    </strong>

                </div>


                <div>

                    <button
                        class="rag-business-button"
                        type="button"
                        data-rag-modal-open="governanceModal">

                        View Governance Examples

                        <span>
                            ↗
                        </span>

                    </button>


                    <button
                        class="rag-business-button secondary"
                        type="button"
                        data-rag-modal-open="adapterModal">

                        View Frontend Adapter Output

                        <span>
                            ↗
                        </span>

                    </button>

                </div>

            </div>

        

            <div class="routing-next-stage-wrap rag-framework-next-wrap">
              <button class="retrieval-ready-compact retrieval-gate-link routing-next-stage-link rag-framework-next-link"
                      type="button"
                      data-rag-next-chapter="6"
                      aria-label="Go to Complete System">
                <small>NEXT STAGE</small>
                <strong>Go to Complete System</strong>
                <span>End-to-end governed RAG-LLM workflow</span>
              </button>
            </div>

        </article>


        <!-- =====================================================
             CHAPTER 06
        ====================================================== -->

        <article
            class="rag-chapter rag-complete-chapter"
            data-rag-chapter="6">

            <div class="rag-chapter-heading">

                <div>

                    <span class="rag-chapter-code">
                        CHAPTER 06 · COMPLETE SYSTEM
                    </span>

                    <h3>
                        One governed path from complaint to operational closure
                    </h3>

                    <p>
                        SmartOps connects controlled RAG-LLM decisions with human authority,
                        technician action and guest notification in one end-to-end maintenance workflow.
                    </p>

                </div>

                <div class="rag-chapter-status">
                    <span></span>
                    END-TO-END GOVERNANCE
                </div>

            </div>


            <div class="rag-e2e-board" aria-label="SmartOps governed hotel maintenance end-to-end pipeline">

                <div class="rag-e2e-lane rag-e2e-lane-guest">

                    <div class="rag-e2e-lane-label">
                        <small>ENTRY + OUTCOME</small>
                        <strong>Guest</strong>
                    </div>

                    <div class="rag-e2e-lane-content">
                        <div class="rag-e2e-track rag-e2e-guest-track">
                            <div class="rag-e2e-node">
                                <small>01 · Complaint</small>
                                <strong>Guest submits maintenance issue</strong>
                                <span>Natural-language message received</span>
                            </div>
                            <div class="rag-e2e-route-line"><span>Governed maintenance journey</span></div>
                            <div class="rag-e2e-node">
                                <small>10 · Notification</small>
                                <strong>Guest receives completion update</strong>
                                <span>Closed-loop service visibility</span>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="rag-e2e-lane rag-e2e-lane-system">

                    <div class="rag-e2e-lane-label">
                        <small>CONTROLLED INTELLIGENCE</small>
                        <strong>SmartOps<br>RAG-LLM</strong>
                    </div>

                    <div class="rag-e2e-lane-content">
                        <div class="rag-e2e-track rag-e2e-system-track">

                            <div class="rag-e2e-node">
                                <small>02 · Route</small>
                                <strong>Classifier + category filter</strong>
                                <span>Search only the supported domain</span>
                            </div>

                            <i class="rag-e2e-arrow" aria-hidden="true">→</i>

                            <div class="rag-e2e-node">
                                <small>03 · Knowledge</small>
                                <strong>Parent-child knowledge base</strong>
                                <span>Parent-only indexing preserves scenarios</span>
                            </div>

                            <i class="rag-e2e-arrow" aria-hidden="true">→</i>

                            <div class="rag-e2e-node">
                                <small>04 · Retrieve</small>
                                <strong>Dense + BM25 + MiniLM</strong>
                                <span>Hybrid search and linked reconstruction</span>
                            </div>

                            <i class="rag-e2e-arrow" aria-hidden="true">→</i>

                            <div class="rag-e2e-node rag-e2e-gate">
                                <small>05 · Gate 1</small>
                                <strong>Is the evidence ready?</strong>
                                <div class="rag-e2e-outcomes">
                                    <b>RAG_READY</b>
                                    <b>RETRIEVAL_HITL</b>
                                    <b>OUT_OF_KB</b>
                                </div>
                            </div>

                            <i class="rag-e2e-arrow" aria-hidden="true">→</i>

                            <div class="rag-e2e-node">
                                <small>06 · Generate</small>
                                <strong>Frozen Prompt V1</strong>
                                <span>Grounded structured recommendation</span>
                            </div>

                            <i class="rag-e2e-arrow" aria-hidden="true">→</i>

                            <div class="rag-e2e-node rag-e2e-gate">
                                <small>07 · Gate 2</small>
                                <strong>Grounding + safety</strong>
                                <div class="rag-e2e-outcomes">
                                    <b>AUTO_APPROVED</b>
                                    <b>HUMAN_REVIEW</b>
                                    <b>RELEASE_BLOCKED</b>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>


                <div class="rag-e2e-lane rag-e2e-lane-human">

                    <div class="rag-e2e-lane-label">
                        <small>HITL AUTHORITY</small>
                        <strong>Human<br>Governance</strong>
                    </div>

                    <div class="rag-e2e-lane-content">
                        <div class="rag-e2e-track rag-e2e-human-track">
                            <div class="rag-e2e-node">
                                <small>Exception</small>
                                <strong>Manager reviews the case</strong>
                                <span>Uncertain or high-risk cases stop here</span>
                            </div>
                            <i class="rag-e2e-arrow" aria-hidden="true">→</i>
                            <div class="rag-e2e-node">
                                <small>Decision</small>
                                <strong>Approve, modify or reject</strong>
                                <span>Human authority remains explicit</span>
                            </div>
                            <i class="rag-e2e-arrow" aria-hidden="true">→</i>
                            <div class="rag-e2e-node">
                                <small>08 · Assignment</small>
                                <strong>Assign the right technician</strong>
                                <span>Only approved work enters operations</span>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="rag-e2e-lane rag-e2e-lane-technician">

                    <div class="rag-e2e-lane-label">
                        <small>OPERATIONAL ACTION</small>
                        <strong>Technician</strong>
                    </div>

                    <div class="rag-e2e-lane-content">
                        <div class="rag-e2e-track rag-e2e-technician-track">
                            <div class="rag-e2e-node">
                                <small>09A · Receive</small>
                                <strong>Accept assigned task</strong>
                                <span>Recommendation becomes accountable work</span>
                            </div>
                            <i class="rag-e2e-arrow" aria-hidden="true">→</i>
                            <div class="rag-e2e-node">
                                <small>09B · Execute</small>
                                <strong>Perform maintenance action</strong>
                                <span>Technician remains responsible for repair</span>
                            </div>
                            <i class="rag-e2e-arrow" aria-hidden="true">→</i>
                            <div class="rag-e2e-node">
                                <small>09C · Close</small>
                                <strong>Complete and document case</strong>
                                <span>Status returns to the guest workflow</span>
                            </div>
                            <i class="rag-e2e-arrow" aria-hidden="true">→</i>
                            <div class="rag-e2e-node rag-e2e-final-outcome">
                                <small>09D · Outcome</small>
                                <strong>Manpower Utilization</strong>
                                <span>Completed work improves workforce visibility and planning</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


            <div class="rag-e2e-principle">
                <span aria-hidden="true">✓</span>
                <div>
                    <strong>AI recommends. Humans govern. Technicians execute.</strong>
                    <small>SmartOps closes the loop from complaint to governed decision, maintenance action and guest notification.</small>
                </div>
                <span>One controlled maintenance system</span>
            </div>

        </article>

    </div>

    <div class="tech-panel" id="validationPanel" data-panel="validation">

      <div class="validation-program">
        <header class="validation-program-hero">
          <div class="validation-program-copy">
            <span>VALIDATION &amp; EXPERIMENTS &middot; V1.2.7 RC1</span>
            <h3>Complete experiment catalogue with six featured contributions</h3>
            <p>The six strongest experiments lead the presentation, including Gate 2 governance, while 15 focused development and validation experiments remain available for evidence, discussion and questions.</p>
          </div>
          <div class="validation-program-highlights" aria-label="Validation programme highlights">
            <article><small>Distinct experiments</small><strong>15</strong><span>Only the most relevant project evidence is retained</span></article>
            <article><small>Featured contributions</small><strong>6</strong><span>Priority stories for the live pitch</span></article>
            <article><small>Frozen retrieval benchmark</small><strong>490</strong><span>98 scenarios with five queries each</span></article>
            <article class="final"><small>Paired acceptance cases</small><strong>50</strong><span>The same cases compared across versions</span></article>
          </div>
        </header>

        <section class="validation-novelty-priority" aria-labelledby="validationNoveltyTitle">
          <header>
            <div><span>FEATURED NOVELTY &amp; EVIDENCE</span><h4 id="validationNoveltyTitle">Six experiments that define the SmartOps contribution</h4></div>
            <p>Select one to open its interactive development pipeline.</p>
          </header>
          <div class="validation-novelty-navigation" aria-label="Featured novelty experiment navigation">
            <button type="button" data-feature-development="E4"><b>01</b><span><small>BENCHMARK FOUNDATION</small><strong>Synthetic Benchmark Dataset</strong><em>98 scenarios &times; 5 queries = 490</em></span></button>
            <button type="button" data-feature-development="E6"><b>02</b><span><small>RETRIEVAL NOVELTY</small><strong>Hybrid Retrieval + Reranking</strong><em>Same 490-query benchmark</em></span></button>
            <button type="button" data-feature-development="E10"><b>03</b><span><small>GATE 1 EVIDENCE</small><strong>Human Review of Calibration Policy</strong><em>Archived policy &middot; 97.37% precision</em></span></button>
            <button type="button" data-feature-development="E17"><b>04</b><span><small>REASONING NOVELTY</small><strong>Generate&ndash;Verify&ndash;Repair Loop</strong><em>4 defined cases &middot; one bounded repair</em></span></button>
            <button type="button" data-feature-development="E18"><b>05</b><span><small>GATE 2 GOVERNANCE</small><strong>Governed Route Regression</strong><em>V1.0 baseline &middot; 5/5 routes passed</em></span></button>
            <button type="button" data-feature-development="E21"><b>06</b><span><small>STRONGEST EVIDENCE</small><strong>Paired Whole-Pipeline Acceptance</strong><em>Grounding 84.44% &rarr; 100%</em></span></button>
          </div>
        </section>

        <div class="validation-program-layout validation-program-layout-audited">
          <nav class="validation-program-nav" aria-label="Validation chapter navigation">
            <span>EXPERIMENT CATALOGUE</span>
            <a href="#validation-data"><b>01</b><span><strong>Data &amp; Complaints</strong><small>E2</small></span></a>
            <a href="#validation-knowledge"><b>02</b><span><strong>Knowledge Base</strong><small>E3</small></span></a>
            <a href="#validation-retrieval"><b>03</b><span><strong>Retrieval &amp; Gate 1</strong><small>E4&ndash;E6 + E8&ndash;E10</small></span></a>
            <a href="#validation-generation"><b>04</b><span><strong>LLM Reasoning</strong><small>E11&ndash;E13 + E17</small></span></a>
            <a href="#validation-system"><b>05</b><span><strong>System &amp; Integration</strong><small>E18&ndash;E19 + E21</small></span></a>
          </nav>

          <div class="validation-program-content">
            <section class="validation-chapter" id="validation-data">
              <header><span>DEVELOPMENT AREA 01</span><h4>Data &amp; Complaint Intelligence</h4><p>Test untouched end-to-end complaint cases without tuning after seeing the result.</p></header>
              <div class="validation-experiment-grid one">
                <article class="validation-experiment-card" data-accent="cyan"><div class="validation-experiment-index">E2</div><div><small>15-CASE OPERATIONAL CHECK</small><h5>Untouched Whole-Pipeline Generalisation</h5><p>Processed one frozen 15-row set through classification, routing, eligible generation and governance without retuning.</p></div><button type="button" data-validation-result="E2">View results <span>&nearr;</span></button></article>
              </div>
            </section>

            <section class="validation-chapter" id="validation-knowledge">
              <header><span>DEVELOPMENT AREA 02</span><h4>Knowledge Base Engineering</h4><p>Confirm that each searchable parent can reconstruct its linked troubleshooting and preventive evidence as one complete maintenance scenario.</p></header>
              <div class="validation-experiment-grid one">
                <article class="validation-experiment-card featured" data-accent="green"><div class="validation-experiment-index">E3</div><div><small>98 SCENARIOS &middot; 294 RECORDS</small><h5>KB Structure &amp; Context Completeness</h5><p>Checked one parent, one troubleshooting child and one preventive child per scenario, linked through scenario_id.</p></div><button type="button" data-validation-result="E3">View results <span>&nearr;</span></button></article>
              </div>
            </section>

            <section class="validation-chapter" id="validation-retrieval">
              <header><span>DEVELOPMENT AREA 03</span><h4>Retrieval Stack &amp; Gate 1</h4><p>Build a repeatable benchmark, compare retrieval choices, validate real complaint behaviour and calibrate the pre-generation readiness gate.</p></header>
              <div class="validation-area-summary"><span><strong>490</strong><small>Same frozen retrieval queries</small></span><span><strong>98</strong><small>Known parent scenarios</small></span><span><strong>150</strong><small>Separate human holdout</small></span><span><strong>0</strong><small>Threshold changes on holdout</small></span></div>
              <div class="validation-experiment-grid">
                <article class="validation-experiment-card" data-accent="blue"><div class="validation-experiment-index">E4</div><div><small>BENCHMARK FOUNDATION</small><h5>Frozen Synthetic RAG Benchmark</h5><p>Built five complaint variants for each of 98 scenarios and locked the expected parent scenario_id.</p></div><button type="button" data-validation-result="E4">View results <span>&nearr;</span></button></article>
                <article class="validation-experiment-card" data-accent="cyan"><div class="validation-experiment-index">E5</div><div><small>SAME 490 QUERIES</small><h5>Category-Filtered vs Global Retrieval</h5><p>Compared known-category filtering with unrestricted global search using the identical benchmark.</p></div><button type="button" data-validation-result="E5">View results <span>&nearr;</span></button></article>
                <article class="validation-experiment-card featured" data-accent="purple"><div class="validation-experiment-index">E6</div><div><small>SAME 490 QUERIES</small><h5>Hybrid Retrieval + MiniLM Reranking</h5><p>Compared candidate order before and after MiniLM while keeping the query set and candidate pool fixed.</p></div><button type="button" data-validation-result="E6">View results <span>&nearr;</span></button></article>
                <article class="validation-experiment-card" data-accent="purple"><div class="validation-experiment-index">E8</div><div><small>500 SEMANTIC JUDGEMENTS</small><h5>LLM-as-a-Judge Retrieval Evaluation</h5><p>Judged selected scenarios and linked evidence for relevance, contradiction and missed safety issues.</p></div><button type="button" data-validation-result="E8">View results <span>&nearr;</span></button></article>
                <article class="validation-experiment-card" data-accent="cyan"><div class="validation-experiment-index">E9</div><div><small>PRECISION-ORIENTED POLICY</small><h5>Retrieval Confidence Gate Calibration</h5><p>Derived readiness controls from dense score, hybrid score, category consistency and context completeness.</p></div><button type="button" data-validation-result="E9">View results <span>&nearr;</span></button></article>
                <article class="validation-experiment-card featured" data-accent="green"><div class="validation-experiment-index">E10</div><div><small>ARCHIVED 150-CASE HOLDOUT</small><h5>Human Review of the Calibration Policy</h5><p>Measured a frozen historical Gate 1 rule against human acceptability labels; the current runtime uses the four readiness signals shown in E9.</p></div><button type="button" data-validation-result="E10">View results <span>&nearr;</span></button></article>
              </div>
            </section>

            <section class="validation-chapter" id="validation-generation">
              <header><span>DEVELOPMENT AREA 04</span><h4>LLM Reasoning, Grounding &amp; Repair</h4><p>Measure structured generation, evaluate semantic quality, refine evidence controls and validate the complete bounded generate&ndash;verify&ndash;repair loop.</p></header>
              <div class="validation-area-summary"><span><strong>30</strong><small>Same generated outputs</small></span><span><strong>29/30</strong><small>Base grounding</small></span><span><strong>0.9766</strong><small>RAGAS faithfulness</small></span><span><strong>1</strong><small>Maximum semantic repair</small></span></div>
              <div class="validation-experiment-grid">
                <article class="validation-experiment-card" data-accent="green"><div class="validation-experiment-index">E11</div><div><small>30 GENERATED RECOMMENDATIONS</small><h5>Generation Quality Baseline</h5><p>Measured schema validity and deterministic grounding on the frozen generated outputs.</p></div><button type="button" data-validation-result="E11">View results <span>&nearr;</span></button></article>
                <article class="validation-experiment-card" data-accent="purple"><div class="validation-experiment-index">E12</div><div><small>SEMANTIC QUALITY ON SAME OUTPUTS</small><h5>RAGAS Recommendation Evaluation</h5><p>Reused the same 30 recommendations to measure faithfulness, answer relevance and context utilisation.</p></div><button type="button" data-validation-result="E12">View results <span>&nearr;</span></button></article>
                <article class="validation-experiment-card" data-accent="blue"><div class="validation-experiment-index">E13</div><div><small>TWO FIVE-CASE PILOTS</small><h5>Prompt Refinement Paired Pilots</h5><p>Tested stricter evidence constraints for recommendation wording, tools and materials.</p></div><button type="button" data-validation-result="E13">View results <span>&nearr;</span></button></article>
                <article class="validation-experiment-card featured" data-accent="purple"><div class="validation-experiment-index">E17</div><div><small>4 TARGETED CASES &middot; 1 REPAIR LIMIT</small><h5>Generate&ndash;Verify&ndash;Repair Complete Loop</h5><p>Developed selected-KB recovery on targeted failures and required every repaired output to be re-verified and re-grounded.</p></div><button type="button" data-validation-result="E17">View results <span>&nearr;</span></button></article>
              </div>
            </section>

            <section class="validation-chapter final" id="validation-system">
              <header><span>DEVELOPMENT AREA 05</span><h4>System, Governance &amp; Integration</h4><p>Verify operational routes, API handover, deterministic regression and final paired whole-pipeline acceptance.</p></header>
              <div class="validation-experiment-grid">
                <article class="validation-experiment-card featured" data-accent="blue"><div class="validation-experiment-index">E18</div><div><small>V1.0 BASELINE · 5 ROUTES</small><h5>Pipeline Route Regression</h5><p>Tested supported release, human review, safety review and correct refusal as valid governed outcomes.</p></div><button type="button" data-validation-result="E18">View results <span>&nearr;</span></button></article>
                <article class="validation-experiment-card" data-accent="cyan"><div class="validation-experiment-index">E19</div><div><small>V1.0 CONTRACT · 4 OUTCOMES</small><h5>FastAPI User Acceptance Testing</h5><p>Validated the frozen deployment handover contract used by the backend and frontend.</p></div><button type="button" data-validation-result="E19">View results <span>&nearr;</span></button></article>
                <article class="validation-experiment-card featured" data-accent="green"><div class="validation-experiment-index">E21</div><div><small>SAME 50 CASES ACROSS VERSIONS</small><h5>Paired Grounding, Repair &amp; Release Acceptance</h5><p>Compared V1.1, V1.2.3 and V1.2.7 without mixing the 50-row acceptance set with any retrieval or holdout dataset.</p></div><button type="button" data-validation-result="E21">View results <span>&nearr;</span></button></article>
              </div>
            </section>
          </div>
        </div>

        <div class="validation-method-note"><strong>PRESENTATION STRUCTURE</strong><span>Six priority experiments lead the pitch</span><span>15 focused experiments remain accessible</span><span>Verifier hardening is included inside the complete-loop experiment</span><span>Each result keeps its interpretation boundary</span></div>

        <dialog class="rag-modal validation-result-modal" id="validationResultModal" aria-labelledby="validationResultTitle">
          <div class="rag-modal-shell validation-result-shell">
            <header class="rag-modal-header validation-result-header">
              <div class="validation-result-header-copy"><small id="validationResultArea">EXPERIMENT RESULT</small><h3 id="validationResultTitle">Validation result</h3><p>Test &middot; Measure &middot; Decide</p></div>
              <div class="validation-result-header-mark" aria-hidden="true"><span id="validationResultId">E01</span><small>SMARTOPS EVIDENCE</small></div>
              <button type="button" data-rag-modal-close aria-label="Close experiment result">&times;</button>
            </header>
            <div class="rag-modal-content validation-result-content">
              <section class="validation-result-audience-brief">
                <div><small>THE QUESTION</small><strong id="validationResultQuestion">What did this experiment need to prove?</strong></div>
                <div class="validation-result-system-path" aria-label="SmartOps controlled pipeline">
                  <span>Complaint</span><i>&rarr;</i><span>Evidence</span><i>&rarr;</i><span>AI control</span><i>&rarr;</i><span>Governed action</span>
                </div>
              </section>
              <div class="validation-result-summary-block"><small>WHAT WAS TESTED</small><p class="validation-result-summary" id="validationResultSummary"></p></div>
              <div class="validation-result-metrics" id="validationResultMetrics"></div>
              <div class="validation-result-story-grid">
                <section class="validation-result-panel"><small>WHAT THE EVIDENCE SHOWED</small><div id="validationResultDetails"></div></section>
                <div class="validation-result-decision-stack">
                  <section class="validation-result-decision"><small>WHAT CHANGED IN SMARTOPS</small><p id="validationResultDecision"></p></section>
                  <section class="validation-result-caveat" id="validationResultCaveatWrap"><small>HOW TO PRESENT THIS RESULT</small><p id="validationResultCaveat"></p></section>
                </div>
              </div>
              <div class="validation-result-evidence"><strong>PROJECT EVIDENCE</strong><span id="validationResultEvidence"></span></div>
            </div>
          </div>
        </dialog>

        <dialog class="rag-modal validation-result-modal validation-development-modal" id="validationDevelopmentModal" aria-labelledby="validationDevelopmentTitle">
          <div class="rag-modal-shell validation-result-shell validation-development-shell">
            <header class="rag-modal-header validation-result-header validation-development-header">
              <div class="validation-development-header-copy">
                <small id="validationDevelopmentArea">EXPERIMENT DEVELOPMENT</small>
                <h3 id="validationDevelopmentTitle">How the experiment was developed</h3>
                <p>From development question to controlled pipeline decision</p>
              </div>
              <div class="validation-development-header-mark" aria-hidden="true">
                <span id="validationDevelopmentId">E01</span>
                <small>BUILD &middot; TEST &middot; LEARN</small>
              </div>
              <button type="button" data-rag-modal-close aria-label="Close experiment development details">&times;</button>
            </header>
            <div class="rag-modal-content validation-result-content validation-development-content">
              <section class="validation-development-section validation-development-flow-section validation-development-focus">
                <div class="validation-development-section-head">
                  <div><small>INTERACTIVE DEVELOPMENT PIPELINE</small><strong>Select a stage to reveal the SmartOps worked example</strong></div>
                  <span id="validationDevelopmentProgress">Stage 01</span>
                </div>
                <div class="validation-development-flow" id="validationDevelopmentFlow"></div>
                <div class="validation-stage-example" aria-live="polite">
                  <header>
                    <span id="validationFlowInsightNumber">01</span>
                    <div><small>SMARTOPS WORKED EXAMPLE</small><strong id="validationFlowInsightTitle">Select a stage</strong><p id="validationFlowInsightText">Choose a stage to inspect the work.</p></div>
                  </header>
                  <div class="validation-stage-visual" id="validationStageVisual"></div>
                  <footer><span>WHY THIS STAGE MATTERS</span><strong id="validationStageOutcome">Pipeline design evidence</strong></footer>
                </div>
              </section>
              <section class="validation-development-bottom-brief">
                <article><small>WHY I RAN THIS EXPERIMENT</small><strong id="validationDevelopmentObjective">Experiment objective</strong></article>
                <article class="outcome"><small>WHAT IT CHANGED IN SMARTOPS</small><strong id="validationDevelopmentOutcome">Experiment outcome</strong></article>
              </section>
            </div>
          </div>
        </dialog>
      </div>

      </div>    <!-- =========================================================
         GATE 1 DETAILS MODAL
    ========================================================== -->

    <dialog
        class="rag-modal rag-large-modal"
        id="gate1Modal">

        <div class="rag-modal-shell">

            <header class="rag-modal-header">

                <div>
                    <small>GATE 1 · UNCERTAINTY CONTROL</small>
                    <h3>Room 305: how Gate 1 controls generation</h3>
                </div>

                <button
                    type="button"
                    data-rag-modal-close
                    aria-label="Close popup">×</button>

            </header>

            <div class="rag-modal-content">

                <div class="rag-gate-detail-grid">

                    <section class="rag-gate-components">

                        <div class="rag-modal-card-label">COMPONENTS CONTROLLED</div>
                        <h4>Four requirements form one eligibility decision</h4>

                        <div class="rag-gate-component-list">

                            <article>
                                <span>01</span>
                                <div><strong>Dense Score · at least 0.55</strong><p>A retained technical floor for semantic similarity between the complaint and selected parent.</p></div>
                            </article>

                            <article>
                                <span>02</span>
                                <div><strong>Hybrid Score · at least 0.20</strong><p>A retained technical floor for the fused BGE-small and BM25 retrieval evidence.</p></div>
                            </article>

                            <article>
                                <span>03</span>
                                <div><strong>Category Consistency · Matched</strong><p>Confirms the retrieved scenario belongs to the predicted D30 HVAC domain.</p></div>
                            </article>

                            <article>
                                <span>04</span>
                                <div><strong>Context Completeness · Complete</strong><p>Confirms the parent, troubleshooting child and preventive child are available.</p></div>
                            </article>

                        </div>

                    </section>

                    <section class="rag-gate-output-example">

                        <div class="rag-modal-card-label">ROOM 305 WORKED EXAMPLE</div>
                        <h4>See why this evidence may proceed to the LLM</h4>

                        <div class="rag-gate-example-case">
                            <span>COMPLAINT EXAMPLE</span>
                            <strong>Room 305</strong>
                            <p>&ldquo;The air conditioner is leaking water.&rdquo;</p>
                            <em>D30 HVAC</em>
                        </div>

                        <div class="rag-gate-example-signals" aria-label="Room 305 Gate 1 readiness signals">
                            <article><small>DENSE SCORE</small><strong>0.81</strong><span>PASS &middot; minimum 0.55</span></article>
                            <article><small>HYBRID SCORE</small><strong>0.78</strong><span>PASS &middot; minimum 0.20</span></article>
                            <article><small>CATEGORY CONSISTENCY</small><strong>Matched</strong><span>PASS &middot; D30 HVAC</span></article>
                            <article><small>CONTEXT COMPLETENESS</small><strong>Complete</strong><span>PASS &middot; parent + 2 children</span></article>
                        </div>

                        <div class="rag-gate-example-decision">
                            <article><small>CALIBRATED CONFIDENCE</small><strong>0.78</strong></article>
                            <i aria-hidden="true">&rarr;</i>
                            <article class="ready"><small>GATE 1 ROUTE</small><strong>RAG_READY</strong><span>Proceed to grounded generation</span></article>
                        </div>

                    </section>

                </div>

                <div class="rag-gate-control-result">
                    <span>CONTROL RULE</span>
                    <strong>Room 305 passes all four requirements</strong>
                    <p>The AC water-leakage evidence becomes RAG_READY and may proceed to the LLM. A failed signal would route the case to RETRIEVAL_HITL or OUT_OF_KB instead.</p>
                </div>

            </div>

        </div>

    </dialog>


    


    <dialog class="rag-modal llm-prompt-modal" id="llmPromptModal">
        <div class="rag-modal-shell">
            <header class="rag-modal-header">
                <div><small>FROZEN PROMPT SPECIFICATION</small><h3>SmartOps AI · Frozen Prompt V1</h3></div>
                <button type="button" data-rag-modal-close aria-label="Close popup">×</button>
            </header>
            <div class="rag-modal-content">
                <pre class="rag-code-block llm-full-prompt-code">You are a hotel maintenance recommendation generator.

Use only the supplied evidence package:
- complaint
- selected parent scenario
- troubleshooting child
- preventive child

Rules:
- Use evidence only.
- Do not invent unsupported diagnoses, tools, procedures or actions.
- Use cautious language such as "possible", "may indicate" and "should be inspected".
- Do not decide severity, priority, approval, escalation or assignment.
- Return one exact JSON object only.

Required JSON fields:
{
  "scenario_summary": string,
  "likely_issue": string,
  "recommended_actions": string[],
  "safety_precautions": string[],
  "preventive_actions": string[],
  "tools_or_materials": string[],
  "evidence": string[],
  "context_sufficient": boolean,
  "information_gaps": string[]
}

When the context is insufficient:
- set context_sufficient to false
- state the gaps
- avoid inventing missing procedures

Return JSON only.</pre>
            </div>
        </div>
    </dialog>


    <!-- =========================================================
         KNOWLEDGE BASE MODAL
    ========================================================== -->

    <dialog
        class="rag-modal"
        id="kbExampleModal">

        <div class="rag-modal-shell">

            <header class="rag-modal-header">

                <div>

                    <small>
                        KNOWLEDGE BASE EXAMPLE
                    </small>

                    <h3>
                        Parent-child structure and parent-only indexing
                    </h3>

                </div>

                <button
                    type="button"
                    data-rag-modal-close
                    aria-label="Close popup">

                    ×

                </button>

            </header>


            <div class="rag-modal-content">

                <div class="rag-example-complaint">

                    <span>
                        EXAMPLE COMPLAINT
                    </span>

                    <strong>
                        “Water is leaking from the indoor
                        air-conditioning unit.”
                    </strong>

                </div>


                <div class="rag-kb-modal-layout">


                    <div class="rag-kb-parent">

                        <div class="rag-modal-card-label">
                            INDEXED PARENT SCENARIO
                        </div>

                        <h4>
                            D30 HVAC · Indoor AC Water Leakage
                        </h4>

                        <dl>

                            <div>

                                <dt>
                                    Scenario ID
                                </dt>

                                <dd>
                                    D30_HVAC_INDOOR_AC_WATER_LEAKAGE
                                </dd>

                            </div>


                            <div>

                                <dt>
                                    Component
                                </dt>

                                <dd>
                                    Indoor AC unit
                                </dd>

                            </div>


                            <div>

                                <dt>
                                    Problem
                                </dt>

                                <dd>
                                    Water leaking near the indoor unit
                                </dd>

                            </div>


                            <div>

                                <dt>
                                    Observed symptom
                                </dt>

                                <dd>
                                    Water dripping around the AC casing
                                </dd>

                            </div>


                            <div>

                                <dt>
                                    Indexing rule
                                </dt>

                                <dd>
                                    Parent scenario is embedded and indexed
                                </dd>

                            </div>

                        </dl>

                    </div>


                    <div class="rag-kb-link-label">

                        <span></span>

                        <strong>
                            linked through scenario_id
                        </strong>

                        <span></span>

                    </div>


                    <div class="rag-kb-child-grid">


                        <div class="rag-kb-child troubleshooting">

                            <div class="rag-modal-card-label">
                                TROUBLESHOOTING CHILD
                            </div>

                            <h4>
                                Corrective evidence
                            </h4>

                            <ul>

                                <li>
                                    Inspect the drain pan for collected water.
                                </li>

                                <li>
                                    Inspect the condensate drain line for blockage.
                                </li>

                                <li>
                                    Inspect the drainage connection for looseness.
                                </li>

                                <li>
                                    Confirm that water can drain correctly.
                                </li>

                            </ul>

                        </div>


                        <div class="rag-kb-child preventive">

                            <div class="rag-modal-card-label">
                                PREVENTIVE CHILD
                            </div>

                            <h4>
                                Preventive evidence
                            </h4>

                            <ul>

                                <li>
                                    Include the condensate path in scheduled inspection.
                                </li>

                                <li>
                                    Verify free drainage during HVAC maintenance.
                                </li>

                                <li>
                                    Record repeated water leakage for further analysis.
                                </li>

                            </ul>

                        </div>


                    </div>


                </div>


                <div class="rag-modal-process">

                    <div>

                        <span>
                            01
                        </span>

                        <strong>
                            Embed parent
                        </strong>

                        <small>
                            Search the complete maintenance scenario.
                        </small>

                    </div>

                    <b>
                        →
                    </b>

                    <div>

                        <span>
                            02
                        </span>

                        <strong>
                            Select parent
                        </strong>

                        <small>
                            Retrieval chooses the strongest scenario.
                        </small>

                    </div>

                    <b>
                        →
                    </b>

                    <div>

                        <span>
                            03
                        </span>

                        <strong>
                            Reconstruct children
                        </strong>

                        <small>
                            Attach corrective and preventive evidence.
                        </small>

                    </div>

                </div>

            </div>

        </div>

    </dialog>


    <!-- =========================================================
         RETRIEVAL MODAL
    ========================================================== -->

    <dialog
        class="rag-modal rag-large-modal"
        id="retrievalExampleModal">

        <div class="rag-modal-shell">

            <header class="rag-modal-header">

                <div>

                    <small>
                        RETRIEVAL TRACE
                    </small>

                    <h3>
                        Top-5 parent scenarios and selected context
                    </h3>

                </div>

                <button
                    type="button"
                    data-rag-modal-close
                    aria-label="Close popup">

                    ×

                </button>

            </header>


            <div class="rag-modal-content">

                <div class="rag-example-complaint">

                    <span>
                        COMPLAINT
                    </span>

                    <strong>
                        “Water is leaking from the indoor
                        air-conditioning unit.”
                    </strong>

                </div>


                <div class="rag-retrieval-modal-grid">


                    <div class="rag-top-five-list">


                        <article class="selected">

                            <span class="rank">
                                01
                            </span>

                            <div>

                                <small>
                                    SELECTED AFTER MINILM RERANKING
                                </small>

                                <strong>
                                    Indoor AC Water Leakage
                                </strong>

                                <p>
                                    Water dripping around an indoor
                                    air-conditioning unit.
                                </p>

                            </div>

                            <b>
                                SELECTED
                            </b>

                        </article>


                        <article>

                            <span class="rank">
                                02
                            </span>

                            <div>

                                <small>
                                    CANDIDATE PARENT
                                </small>

                                <strong>
                                    Condensate Drain Line Blockage
                                </strong>

                                <p>
                                    Restricted or obstructed condensate drainage.
                                </p>

                            </div>

                        </article>


                        <article>

                            <span class="rank">
                                03
                            </span>

                            <div>

                                <small>
                                    CANDIDATE PARENT
                                </small>

                                <strong>
                                    Drain Pan Overflow
                                </strong>

                                <p>
                                    Collected water overflowing from the indoor unit.
                                </p>

                            </div>

                        </article>


                        <article>

                            <span class="rank">
                                04
                            </span>

                            <div>

                                <small>
                                    CANDIDATE PARENT
                                </small>

                                <strong>
                                    Indoor Unit Condensation
                                </strong>

                                <p>
                                    Visible moisture around the AC casing.
                                </p>

                            </div>

                        </article>


                        <article>

                            <span class="rank">
                                05
                            </span>

                            <div>

                                <small>
                                    CANDIDATE PARENT
                                </small>

                                <strong>
                                    HVAC Drainage Connection Fault
                                </strong>

                                <p>
                                    Loose or leaking condensate connection.
                                </p>

                            </div>

                        </article>


                    </div>


                    <div class="rag-selected-context-card">

                        <div class="rag-selected-context-header">

                            <small>
                                FINAL RETRIEVED CONTEXT
                            </small>

                            <strong>
                                Selected Parent + Linked Evidence
                            </strong>

                        </div>


                        <article>

                            <span>
                                PARENT
                            </span>

                            <p>
                                Water is leaking or dripping around the
                                indoor air-conditioning unit.
                            </p>

                        </article>


                        <article>

                            <span>
                                TROUBLESHOOTING
                            </span>

                            <p>
                                Inspect the drain pan, condensate drain line
                                and drainage connection for blockage,
                                overflow or looseness.
                            </p>

                        </article>


                        <article>

                            <span>
                                PREVENTIVE
                            </span>

                            <p>
                                Include the condensate drainage system in
                                scheduled HVAC inspection and verify free flow.
                            </p>

                        </article>


                        <div class="rag-context-complete">

                            <span>
                                ✓
                            </span>

                            <strong>
                                Evidence package is ready for Gate 1
                            </strong>

                        </div>

                    </div>


                </div>

            </div>

        </div>

    </dialog>


    <!-- =========================================================
         GOVERNANCE MODAL
    ========================================================== -->

    <dialog
        class="rag-modal rag-large-modal"
        id="governanceModal">

        <div class="rag-modal-shell">

            <header class="rag-modal-header">

                <div>

                    <small>
                        GATE 2 DECISION EXAMPLES
                    </small>

                    <h3>
                        Three maintenance cases. Three controlled outcomes.
                    </h3>

                </div>

                <button
                    type="button"
                    data-rag-modal-close
                    aria-label="Close popup">

                    ×

                </button>

            </header>


            <div class="rag-modal-content">

                <div class="rag-governance-example-grid">


                    <article class="approved">

                        <div class="rag-example-case-head">
                            <span>AUTO_APPROVED</span>
                            <b>LOW RISK</b>
                        </div>

                        <h4>
                            Room 218 · Bedside lamp not working
                        </h4>

                        <p class="rag-example-case-complaint">
                            “The bedside lamp does not switch on.”
                        </p>

                        <dl class="rag-decision-facts">
                            <div><dt>JSON</dt><dd>Valid</dd></div>
                            <div><dt>Evidence</dt><dd>Fully grounded</dd></div>
                            <div><dt>Severity</dt><dd>LOW</dd></div>
                            <div><dt>Safety flag</dt><dd>None</dd></div>
                        </dl>

                        <div class="rag-decision-result">
                            <small>CONTROL ACTION</small>
                            <strong>Release to technician queue</strong>
                        </div>

                    </article>


                    <article class="review">

                        <div class="rag-example-case-head">
                            <span>HUMAN_REVIEW</span>
                            <b>HIGH SEVERITY</b>
                        </div>

                        <h4>
                            Room 305 · Indoor AC water leakage
                        </h4>

                        <p class="rag-example-case-complaint">
                            “Water is leaking from the indoor air-conditioning unit.”
                        </p>

                        <dl class="rag-decision-facts">
                            <div><dt>JSON</dt><dd>Valid</dd></div>
                            <div><dt>Evidence</dt><dd>Grounded</dd></div>
                            <div><dt>Severity</dt><dd>HIGH</dd></div>
                            <div><dt>Approval</dt><dd>Human required</dd></div>
                        </dl>

                        <div class="rag-decision-result">
                            <small>CONTROL ACTION</small>
                            <strong>Hold for manager approval</strong>
                        </div>

                    </article>


                    <article class="blocked">

                        <div class="rag-example-case-head">
                            <span>RELEASE_BLOCKED</span>
                            <b>SAFETY CONFLICT</b>
                        </div>

                        <h4>
                            Room 412 · Sparks from wall socket
                        </h4>

                        <p class="rag-example-case-complaint">
                            “The wall socket sparked when I connected the kettle.”
                        </p>

                        <dl class="rag-decision-facts">
                            <div><dt>JSON</dt><dd>Valid</dd></div>
                            <div><dt>Evidence</dt><dd>Unsupported action detected</dd></div>
                            <div><dt>Severity</dt><dd>CRITICAL</dd></div>
                            <div><dt>Safety flag</dt><dd>Electrical hazard</dd></div>
                        </dl>

                        <div class="rag-decision-result">
                            <small>CONTROL ACTION</small>
                            <strong>Block release and escalate</strong>
                        </div>

                    </article>


                </div>


                <div class="rag-governance-summary">

                    <strong>
                        Generation and authority remain separate.
                    </strong>

                    <span>
                        The LLM creates a recommendation.
                        Deterministic rules decide whether operations may use it.
                    </span>

                </div>

            </div>

        </div>

    </dialog>


    <!-- =========================================================
         FRONTEND ADAPTER MODAL
    ========================================================== -->

    <dialog
        class="rag-modal rag-code-modal"
        id="adapterModal">

        <div class="rag-modal-shell">

            <header class="rag-modal-header">

                <div>

                    <small>
                        FINAL FRONTEND ADAPTER OUTPUT
                    </small>

                    <h3>
                        Room 305 · Indoor AC Water Leakage
                    </h3>

                </div>

                <button
                    type="button"
                    data-rag-modal-close
                    aria-label="Close popup">

                    ×

                </button>

            </header>


            <div class="rag-modal-content">


                <div class="rag-adapter-metrics">


                    <div>

                        <small>
                            RETRIEVAL
                        </small>

                        <strong>
                            RAG_READY
                        </strong>

                    </div>


                    <div>

                        <small>
                            SEVERITY
                        </small>

                        <strong>
                            HIGH
                        </strong>

                    </div>


                    <div>

                        <small>
                            APPROVAL
                        </small>

                        <strong>
                            HUMAN REQUIRED
                        </strong>

                    </div>


                    <div>

                        <small>
                            RELEASE
                        </small>

                        <strong>
                            HUMAN_REVIEW_ONLY
                        </strong>

                    </div>


                </div>


                <pre class="rag-code-block">{
    &quot;schema_version&quot;: &quot;1.0&quot;,
    &quot;pipeline_version&quot;: &quot;1.0.0&quot;,
    &quot;case_id&quot;: &quot;SSAI-305&quot;,
    &quot;received_timestamp&quot;: &quot;2026-08-02T10:21:00+08:00&quot;,
    &quot;room_id&quot;: &quot;Room 305&quot;,
    &quot;cleaned_comment&quot;: &quot;Water is leaking from the indoor air-conditioning unit.&quot;,
    &quot;hotel_asset&quot;: &quot;D30 HVAC&quot;,
    &quot;classification&quot;: {
        &quot;category&quot;: &quot;D30 HVAC&quot;,
        &quot;confidence&quot;: 0.94
    },
    &quot;candidate_metadata&quot;: {
        &quot;scenario_id&quot;: &quot;D30_HVAC_INDOOR_AC_WATER_LEAKAGE&quot;,
        &quot;component&quot;: &quot;Indoor AC Unit&quot;,
        &quot;failure_mode&quot;: &quot;Possible condensate drainage issue&quot;,
        &quot;observed_symptoms&quot;: [
            &quot;Water dripping near the indoor AC unit&quot;
        ],
        &quot;safety_flag&quot;: false
    },
    &quot;governance_decision&quot;: {
        &quot;retrieval_status&quot;: &quot;RAG_READY&quot;,
        &quot;approval_status&quot;: &quot;HUMAN_APPROVAL_REQUIRED&quot;,
        &quot;severity&quot;: &quot;HIGH&quot;,
        &quot;priority&quot;: &quot;P2_URGENT&quot;,
        &quot;escalation_status&quot;: &quot;STANDARD_ESCALATION&quot;,
        &quot;safety_flags&quot;: [],
        &quot;kb_safety_flag&quot;: false,
        &quot;recommendation_release_allowed&quot;: false,
        &quot;requires_human_review&quot;: true
    },
    &quot;recommendation&quot;: {
        &quot;state&quot;: &quot;HUMAN_REVIEW_ONLY&quot;,
        &quot;scenario_summary&quot;: &quot;Water is leaking near the indoor air-conditioning unit.&quot;,
        &quot;likely_issue&quot;: &quot;A possible condensate drain blockage, drain-pan overflow or insecure drainage connection.&quot;,
        &quot;corrective_actions&quot;: [
            &quot;Inspect the drain pan for collected water or overflow.&quot;,
            &quot;Inspect the condensate drain line for blockage.&quot;,
            &quot;Inspect the drainage connection for looseness or leakage.&quot;
        ],
        &quot;preventive_actions&quot;: [
            &quot;Include the condensate drainage path in scheduled HVAC inspection.&quot;,
            &quot;Verify that condensate water drains without obstruction.&quot;
        ],
        &quot;verification_steps&quot;: [
            &quot;Confirm that water drains correctly.&quot;,
            &quot;Confirm that no further water leakage is visible.&quot;
        ],
        &quot;safety_precautions&quot;: [
            &quot;Keep the wet area isolated during inspection.&quot;
        ]
    }
}</pre>


                <p class="rag-code-note">
                    Classification, retrieval readiness, severity,
                    approval, escalation and release state are determined
                    outside the LLM by the SmartOps adapter and governance rules.
                </p>

            </div>

        </div>

    </dialog>


    <!-- =========================================================
         LLM RESULTS MODAL
    ========================================================== -->

    <dialog class="rag-modal rag-large-modal llm-results-modal" id="llmResultsModal">
        <div class="rag-modal-shell">
            <header class="rag-modal-header">
                <div>
                    <small>LLM ENGINEERING RESULTS · V1.1 TO V1.2.7 RC1</small>
                    <h3>Main grounding and release improvements</h3>
                </div>
                <button type="button" data-rag-modal-close aria-label="Close popup">×</button>
            </header>

            <div class="rag-modal-content">
                <div class="llm-results-focus" aria-label="Main LLM improvements">
                    <article>
                        <small>GROUNDING VALID</small>
                        <strong>84.44% → 100%</strong>
                        <span>+15.56 percentage points</span>
                    </article>
                    <article>
                        <small>AUTO-APPROVED</small>
                        <strong>26/50 → 32/50</strong>
                        <span>+6 cases</span>
                    </article>
                </div>

                <div class="llm-results-table-wrap">
                    <table class="llm-results-table">
                        <caption>Complete comparison of the V1.1 baseline and final V1.2.7 RC1 acceptance record</caption>
                        <thead>
                            <tr>
                                <th scope="col">Metric</th>
                                <th scope="col">V1.1 baseline</th>
                                <th scope="col">V1.2.7 RC1</th>
                                <th scope="col">Change</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><th scope="row">Classification accuracy</th><td>94%</td><td>94%</td><td>Unchanged</td></tr>
                            <tr><th scope="row"><code>RAG_READY</code></th><td>45/50</td><td>45/50</td><td>Unchanged</td></tr>
                            <tr><th scope="row">Schema valid</th><td>100%</td><td>100%</td><td>Unchanged</td></tr>
                            <tr class="llm-result-priority grounding">
                                <th scope="row"><span class="llm-result-focus-tag">PRESENTATION FOCUS</span>Grounding valid</th>
                                <td>38/45, 84.44%</td><td><strong>45/45, 100%</strong></td><td><strong>+15.56 points</strong></td>
                            </tr>
                            <tr class="llm-result-priority approval">
                                <th scope="row"><span class="llm-result-focus-tag">PRESENTATION FOCUS</span>Auto-approved</th>
                                <td>26/50</td><td><strong>32/50</strong></td><td><strong>+6 cases</strong></td>
                            </tr>
                            <tr><th scope="row">Release rate</th><td>52%</td><td><strong>64%</strong></td><td><strong>+12 points</strong></td></tr>
                            <tr><th scope="row">Human review</th><td>24/50</td><td><strong>18/50</strong></td><td><strong>−6 cases</strong></td></tr>
                            <tr><th scope="row">Repair recovery</th><td>Not available</td><td><strong>9/9</strong></td><td>All attempted repairs recovered</td></tr>
                            <tr><th scope="row">Critical auto-approved</th><td>0</td><td><strong>0</strong></td><td>Safety preserved</td></tr>
                            <tr><th scope="row">Active hazards auto-approved</th><td>0</td><td><strong>0</strong></td><td>Safety preserved</td></tr>
                        </tbody>
                    </table>
                </div>

                <p class="llm-results-note"><strong>Presentation takeaway:</strong> Grounding reached 100%, all nine attempted repairs recovered, and automatic approval increased by six cases without auto-approving critical or active-hazard cases.</p>
            </div>
        </div>
    </dialog>


</section>
<section class="content-section integration-section" id="integration" data-section="integration">
  <div class="section-heading integration-heading reveal">
    <span class="section-number">INT</span>
    <div>
      <div class="section-kicker">System Integration Architecture</div>
      <h2>One integration layer connects intelligence to operations</h2>
      <p>The SmartOps backend coordinates every channel, system and AI service so one complaint can move safely from intake to governed maintenance action.</p>
    </div>
  </div>

  <div class="integration-architecture reveal" aria-label="SmartOps AI integration architecture">
    <div class="integration-grid-pattern" aria-hidden="true"></div>

    <div class="integration-flow-diagram" aria-label="Connected SmartOps frontend, backend, AI, database and WhatsApp services">
      <article class="integration-node integration-node-web">
        <span class="integration-node-icon" aria-hidden="true">
          <svg viewBox="0 0 48 48"><rect x="5" y="7" width="38" height="34" rx="4"/><path d="M5 16h38M11 11.5h.01M16 11.5h.01M21 11.5h.01M11 22h11v12H11zM27 22h10M27 28h10M27 34h7"/></svg>
        </span>
        <div><small>USER EXPERIENCE</small><h3>Web Frontend</h3><p>Admin and technician interfaces</p></div>
      </article>

      <div class="integration-route integration-route-horizontal integration-route-web">
        <span>REST API / JSON</span>
        <div class="integration-route-lines" aria-hidden="true"><i class="outbound"></i><i class="return"></i></div>
      </div>

      <article class="integration-node integration-node-core">
        <span class="integration-node-icon" aria-hidden="true">
          <svg viewBox="0 0 48 48"><rect x="7" y="6" width="34" height="10" rx="3"/><rect x="7" y="19" width="34" height="10" rx="3"/><rect x="7" y="32" width="34" height="10" rx="3"/><path d="M13 11h.01M13 24h.01M13 37h.01M19 11h15M19 24h15M19 37h15"/></svg>
        </span>
        <div><small>CENTRAL ORCHESTRATION</small><h3>Backend Integration Service</h3><p>Coordinates application state, AI results and governed actions</p></div>
      </article>

      <div class="integration-route integration-route-horizontal integration-route-rag">
        <span>FastAPI REST API / JSON<br><code>POST /api/v1/recommendation</code></span>
        <div class="integration-route-lines" aria-hidden="true"><i class="outbound"></i><i class="return"></i></div>
      </div>

      <article class="integration-node integration-node-rag">
        <span class="integration-node-icon" aria-hidden="true">
          <svg viewBox="0 0 48 48"><path d="M17 12a6 6 0 0 1 11-3 6 6 0 0 1 7 8 6 6 0 0 1 2 11 6 6 0 0 1-8 8 6 6 0 0 1-10 1 6 6 0 0 1-8-8 6 6 0 0 1 1-11 6 6 0 0 1 5-6Z"/><path d="M24 8v32M17 16h7M24 22h8M15 29h9M24 34h6"/></svg>
        </span>
        <div><small>RECOMMENDATION SERVICE</small><h3>SmartOps RAG-LLM Pipeline</h3><p>Retrieves evidence, generates and validates recommendations</p></div>
      </article>

      <article class="integration-node integration-node-sql">
        <span class="integration-node-icon" aria-hidden="true">
          <svg viewBox="0 0 48 48"><ellipse cx="24" cy="10" rx="15" ry="6"/><path d="M9 10v11c0 3 7 6 15 6s15-3 15-6V10M9 21v11c0 3 7 6 15 6s15-3 15-6V21"/></svg>
        </span>
        <div><small>OPERATIONAL SYSTEM OF RECORD</small><h3>SQL Database</h3><p>Complaints, approvals and assignments</p></div>
      </article>

      <div class="integration-route integration-route-horizontal integration-route-sql">
        <span>SQL / ORM</span>
        <div class="integration-route-lines" aria-hidden="true"><i class="outbound"></i><i class="return"></i></div>
      </div>

      <div class="integration-route integration-route-vertical integration-route-rag-kb">
        <span>HYBRID RETRIEVAL</span>
        <div class="integration-route-lines" aria-hidden="true"><i class="outbound"></i><i class="return"></i></div>
      </div>

      <article class="integration-node integration-node-kb">
        <span class="integration-node-icon" aria-hidden="true">
          <svg viewBox="0 0 48 48"><ellipse cx="20" cy="10" rx="12" ry="5"/><path d="M8 10v19c0 3 5 5 12 5M32 10v11M8 20c0 3 5 5 12 5s12-2 12-5"/><circle cx="34" cy="31" r="7"/><path d="m39 36 6 6"/></svg>
        </span>
        <div><small>RETRIEVAL STORE</small><h3>ChromaDB + BM25</h3><p>Parent vectors with linked child-context reconstruction</p></div>
      </article>

      <div class="integration-route integration-route-vertical integration-route-core-wa">
        <span>WEBHOOK &#8593;<br>&#8595; WHATSAPP CLOUD API</span>
        <div class="integration-route-lines" aria-hidden="true"><i class="outbound"></i><i class="return"></i></div>
      </div>

      <article class="integration-node integration-node-whatsapp">
        <span class="integration-node-icon" aria-hidden="true">
          <svg viewBox="0 0 64 64"><path d="M32 6C18.2 6 7 16.7 7 29.9c0 4.4 1.3 8.7 3.7 12.4L7.6 57l15.3-3.9c2.9 1.5 6 2.3 9.1 2.3 13.8 0 25-10.7 25-23.9S45.8 6 32 6Z"/><path d="M21.2 17.5h2.2c1.1 0 2 .7 2.3 1.7l1.8 5.4c.3.9 0 1.9-.7 2.5l-2.1 1.8c2.4 4.5 6 8.1 10.5 10.5l1.8-2.1c.6-.7 1.6-1 2.5-.7l5.4 1.8c1 .3 1.7 1.2 1.7 2.3v2.2c0 1.6-1.2 2.9-2.8 3.1-13.7 1.5-25.3-10.1-23.8-23.8.3-1.5 1.6-2.7 3.2-2.7Z"/></svg>
        </span>
        <div><small>MESSAGE CHANNEL</small><h3>WhatsApp Cloud API</h3><p>Receives guest reports and sends status notifications</p></div>
      </article>

      <div class="integration-route integration-route-horizontal integration-route-wa-user">
        <span>MESSAGES</span>
        <div class="integration-route-lines" aria-hidden="true"><i class="outbound"></i><i class="return"></i></div>
      </div>

      <article class="integration-node integration-node-user">
        <span class="integration-node-icon" aria-hidden="true">
          <svg viewBox="0 0 48 48"><circle cx="24" cy="15" r="8"/><path d="M9 41c1-10 6-15 15-15s14 5 15 15M33 31h8v7h-5l-3 3v-10Z"/></svg>
        </span>
        <div><small>COMPLAINT ORIGIN</small><h3>WhatsApp User</h3><p>Guest reports an issue and receives status updates</p></div>
      </article>
    </div>

    <div class="integration-principle">
      <span aria-hidden="true">&#9733;</span>
      <div><small>INTEGRATION PRINCIPLE</small><strong>The backend is the central integration layer.</strong></div>
      <div class="integration-principle-guide">
        <div class="integration-flow-legend" aria-label="Connection direction legend">
          <span class="request"><i aria-hidden="true"></i>Request / command</span>
          <span class="response"><i aria-hidden="true"></i>Response / status</span>
        </div>
        <p>PHP and FastAPI coordinate AI recommendations; MySQL remains the operational system of record.</p>
      </div>
    </div>
  </div>
</section>
<section class="content-section how-smartops-after-rag" aria-label="How SmartOps works">
  <div class="how-smartops-standalone how-smartops-restored" aria-label="How SmartOps works interactive demonstration">
    <div id="howSmartOpsInlineMount" class="how-smartops-inline-mount"></div>
  </div>
</section>
<script src="assets/how-smartops-component.js?v=<?= e($assetVersion) ?>"></script>
<section class="content-section platform-section" id="platform" data-section="platform">
      <div class="section-heading reveal">
        <span class="section-number">06</span>
        <div>
          <div class="section-kicker">Operational Web Platform</div>
          <h2>Two roles one governed maintenance workflow</h2>
          <p>The hotel prototype connects management oversight with a focused technician work experience</p>
        </div>
      </div>

      <figure class="role-showcase-visual reveal">
        <img
          src="assets/diagrams/two_roles_governed_cards.png?v=<?= e($assetVersion) ?>"
          alt="SmartOps role cards showing the Admin and Maintenance Manager dashboard and a hotel technician using the mobile task dashboard"
          class="role-showcase-image"
          loading="lazy"
        >
      </figure>

      <div class="coded-diagram-shell swimlane-code-shell reveal">
        <div class="coded-diagram-head">
          <div><span>HUMAN-GOVERNED ROUTING</span><h3>SmartOps Human-Governed Ticket Routing</h3></div>
          <p>Routine cases are automated while high-risk or uncertain cases remain under human oversight</p>
        </div>
        <div class="human-workflow-image-wrap">
            <img
              src="assets/diagrams/smartops_human_governed_ticket_routing.png"
              alt="SmartOps human-governed ticket routing workflow showing system routing, HITL review, technician actions and guest notification"
              class="human-workflow-image"
              loading="lazy"
            >
          </div>
        </div>
      </div>

      <div class="hitl-future hitl-future-v2 reveal">
        <div class="hitl-grid-bg" aria-hidden="true"></div>
        <div class="hitl-heading"><span>WHY HITL MATTERS</span><h3>Human oversight where automation should stop</h3></div>
        <div class="hitl-neural-map" aria-label="HITL governance visual">
          <div class="hitl-scanline" aria-hidden="true"></div>
          <div class="hitl-core hitl-core-v2"><div class="hitl-core-ring"></div><div class="hitl-core-ring ring-secondary"></div><strong>HITL</strong><small>Human-in-the-loop</small></div>
          <article class="hitl-node hitl-node-a"><span>01</span><div><strong>Risk &amp; Exception Escalation</strong><small>Escalate safety-critical, low-confidence, or OUT_OF_KB cases for human review.</small></div></article>
          <article class="hitl-node hitl-node-b"><span>02</span><div><strong>Manpower Utilization</strong><small>Use technician availability, workload, and skills to assign tasks efficiently.</small></div></article>
          <article class="hitl-node hitl-node-c"><span>03</span><div><strong>Human Approval &amp; Governance</strong><small>Managers review, approve, adjust, and assign escalated cases.</small></div></article>
          <i class="hitl-link link-a" aria-hidden="true"></i><i class="hitl-link link-b" aria-hidden="true"></i><i class="hitl-link link-c" aria-hidden="true"></i>
          <span class="hitl-data-point point-a"></span><span class="hitl-data-point point-b"></span><span class="hitl-data-point point-c"></span><span class="hitl-data-point point-d"></span>
        </div>
        <p class="hitl-statement">AI automates routine cases <strong>Humans govern exceptions</strong> Technicians execute safely</p>
      </div>
    </section>
    <section class="content-section demo-section demo-section-v2 demo-hero-v3" id="live-demo" data-section="live-demo">
      <div class="demo-glow" aria-hidden="true"></div>

      <div class="demo-hero-grid reveal">
        <div class="demo-hero-copy">
          <span class="demo-hero-number">07</span>
          <div class="demo-hero-kicker">Live System Demo</div>

          <h2>Experience the end-<br>to-end operational<br>workflow</h2>

          <p class="demo-hero-description">
            Follow one hotel maintenance complaint from AI analysis and HITL approval to technician completion — inside the same SmartOps system.
          </p>

          <div class="demo-hero-flow" aria-label="Live demo workflow">
            <article>
              <span>1</span>
              <strong>Complaint</strong>
              <small>WhatsApp intake</small>
            </article>
            <i aria-hidden="true">→</i>
            <article>
              <span>2</span>
              <strong>AI Analysis</strong>
              <small>Category + severity</small>
            </article>
            <i aria-hidden="true">→</i>
            <article>
              <span>3</span>
              <strong>HITL Review</strong>
              <small>Manager decision</small>
            </article>
            <i aria-hidden="true">→</i>
            <article>
              <span>4</span>
              <strong>Technician</strong>
              <small>Accept + complete</small>
            </article>
            <i aria-hidden="true">→</i>
            <article>
              <span>5</span>
              <strong>Update</strong>
              <small>Operational visibility</small>
            </article>
          </div>

          <div class="demo-hero-actions">
            <a class="demo-hero-button demo-page-launch" href="guided_demo.php?reset=1">
              <span>Start Live<br>Demo</span>
              <b aria-hidden="true">↗</b>
            </a>
            <small class="demo-hero-note">
              The guided Room 305 demo opens in the same tab and includes a Return to Product Website control.
            </small>
          </div>
        </div>

        <div class="demo-hero-browser" aria-hidden="true">
          <div class="demo-browser-window">
            <div class="demo-browser-titlebar">
              <div class="demo-browser-lights"><i></i><i></i><i></i></div>
              <div class="demo-browser-url">smartops.ai/demo</div>
            </div>

            <div class="demo-browser-content">
              <aside class="demo-browser-sidebar-v3">
                <strong>SmartOps AI</strong>
                <span class="active"></span>
                <span></span>
                <span></span>
                <span></span>
              </aside>

              <main class="demo-browser-main-v3">
                <header>
                  <div>
                    <small>EXECUTIVE OVERVIEW</small>
                    <h3>Operational Maintenance</h3>
                  </div>
                  <b>LIVE</b>
                </header>

                <div class="demo-browser-kpis-v3">
                  <article><small>Total complaints</small><strong>128</strong></article>
                  <article><small>HITL required</small><strong>09</strong></article>
                  <article><small>SLA risks</small><strong>04</strong></article>
                </div>

                <div class="demo-browser-panels-v3">
                  <article class="demo-browser-bars-v3">
                    <i style="height:42%"></i>
                    <i style="height:72%"></i>
                    <i style="height:55%"></i>
                    <i style="height:84%"></i>
                  </article>
                  <article class="demo-browser-progress-v3">
                    <span><i style="width:58%"></i></span>
                    <span><i style="width:80%"></i></span>
                    <span><i style="width:45%"></i></span>
                    <span><i style="width:70%"></i></span>
                    <span><i style="width:57%"></i></span>
                  </article>
                </div>
              </main>
            </div>
          </div>
        </div>
      </div>

      <div class="demo-workspace-wrap" id="demoWorkspace" hidden>
        <div class="demo-guide-bar"><span>GUIDED DEMO</span><strong id="demoGuideText">Open the HITL Dashboard and review the pending Room 305 case</strong><i id="demoGuideStep">Step 1 of 6</i></div>
        <div class="demo-app-shell" id="embeddedDemo">
          <div class="demo-browser-bar demo-browser-bar-v2">
            <div class="demo-browser-dots"><span></span><span></span><span></span></div>
            <div class="demo-browser-address">smartops demo / isolated visitor session / room 305</div>
            <div class="demo-fresh-badge"><span></span>FRESH SESSION</div>
          </div>

          <div class="demo-system-layout">
            <aside class="demo-system-sidebar">
              <div class="demo-mini-brand"><span>S</span><div><strong>SmartOps AI</strong><small>Demo System</small></div></div>
              <nav aria-label="Demo navigation">
                <button class="demo-nav-item active" type="button" data-demo-view="overview"><span>⌂</span>Admin Overview</button>
                <button class="demo-nav-item guided-target" type="button" data-demo-view="hitl"><span>!</span>HITL Dashboard<i id="demoPendingCount">1</i></button>
                <button class="demo-nav-item" type="button" data-demo-view="technician"><span>⌁</span>Technician Dashboard</button>
                <button class="demo-nav-item" type="button" data-demo-view="notifications"><span>◉</span>Notifications<i id="demoNotificationCount">0</i></button>
              </nav>
              <div class="demo-case-summary"><small>DEMO CASE</small><strong>SSAI-ROOM-305</strong><span>HVAC water leakage</span><b id="demoSidebarStatus">Pending HITL</b></div>
            </aside>

            <div class="demo-system-main">
              <section class="demo-dashboard-view active" data-demo-view-panel="overview">
                <div class="demo-system-head"><div><small>ADMIN DASHBOARD</small><h3>Operational Maintenance Overview</h3></div><span class="demo-live-pill">LIVE DEMO</span></div>
                <div class="demo-kpi-row"><article><small>Total complaints</small><strong>128</strong><span>Last 7 days</span></article><article><small>Unsolved</small><strong>09</strong><span>Requires action</span></article><article class="warning"><small>HITL required</small><strong id="overviewHitlCount">01</strong><span>Room 305 pending</span></article><article><small>Technicians</small><strong>06</strong><span>Available now</span></article></div>
                <div class="demo-overview-grid"><article class="demo-chart-card"><div class="demo-card-head"><strong>Daily Resolution Trend</strong><small>7 days</small></div><div class="demo-chart-bars"><i style="height:44%"></i><i style="height:66%"></i><i style="height:52%"></i><i style="height:80%"></i><i style="height:60%"></i><i style="height:92%"></i><i style="height:76%"></i></div></article><article class="demo-queue-card"><div class="demo-card-head"><strong>Action Required</strong><small>Current</small></div><button class="demo-queue-row guided-target" type="button" data-open-view="hitl"><span class="queue-severity">HIGH</span><div><strong>Room 305 · HVAC Leakage</strong><small>Pending manager review</small></div><i>→</i></button><div class="demo-empty-lines"><span></span><span></span><span></span></div></article></div>
              </section>

              <section class="demo-dashboard-view" data-demo-view-panel="hitl">
                <div class="demo-system-head"><div><small>ADMIN · HITL</small><h3>HITL Escalation Dashboard</h3></div><span class="demo-live-pill danger" id="demoHitlHeaderPill">1 PENDING</span></div>
                <div class="demo-hitl-tabs"><button class="active guided-target" id="demoPendingTab" type="button">Pending Review <span id="pendingTabCount">1</span></button><button type="button">Reviewed</button><button type="button">OUT_OF_KB</button></div>
                <div class="demo-pending-table" id="demoPendingTable">
                  <div class="demo-table-head"><span>Case</span><span>Location</span><span>Category</span><span>Severity</span><span>Status</span><span>Action</span></div>
                  <div class="demo-table-row" id="demoRoom305Row"><span><strong>SSAI-ROOM-305</strong><small>Water leaking from air-conditioning unit</small></span><span>Room 305</span><span>D30 HVAC</span><span><b class="table-high">HIGH</b></span><span><b class="table-pending" id="demoRowStatus">Pending</b></span><span><button class="demo-table-action guided-target" type="button" id="demoReviewCase">Review case</button></span></div>
                </div>
                <div class="demo-review-drawer" id="demoReviewDrawer" hidden>
                  <div class="review-drawer-head"><div><small>HIGH-SEVERITY REVIEW</small><h4>Room 305 · HVAC Leakage</h4></div><span>HITL REQUIRED</span></div>
                  <div class="review-drawer-grid"><article><small>AI diagnosis</small><strong>Indoor AC drainage blockage</strong><p>Water is dripping near the indoor unit and creating a wet-floor hazard</p></article><article><small>Grounded recommendation</small><strong>Inspect drain pan and clear the drain pipe</strong><p>Isolate the affected area before repair</p></article></div>
                  <div class="review-assignment"><label for="demoTechnicianSelect">Assign technician</label><select id="demoTechnicianSelect"><option>Amir Hassan · HVAC</option><option>Jason Lim · HVAC</option></select><button class="demo-primary-action guided-target" type="button" id="demoAssignTechnician">Approve and assign technician</button></div>
                </div>
              </section>

              <section class="demo-dashboard-view" data-demo-view-panel="technician">
                <div class="demo-system-head"><div><small>TECHNICIAN PORTAL</small><h3>Assigned Maintenance Work</h3></div><span class="demo-live-pill technician-pill" id="demoTechnicianPill">WAITING</span></div>
                <div class="demo-technician-empty" id="demoTechnicianEmpty"><span>⌁</span><h4>No task assigned yet</h4><p>Complete the manager assignment in the HITL Dashboard first</p></div>
                <div class="demo-technician-case" id="demoTechnicianCase" hidden>
                  <div class="tech-case-head"><div><span class="queue-severity">HIGH</span><small>ASSIGNED TASK</small><h4>Room 305 · HVAC Leakage</h4></div><b id="demoTechCaseStatus">Assigned</b></div>
                  <div class="tech-case-body"><article><small>Issue</small><strong>Water leaking from indoor AC unit</strong></article><article><small>Recommended action</small><strong>Inspect drain pan and clear drain pipe blockage</strong></article><article><small>Guest safety</small><strong>Keep the wet area isolated during repair</strong></article></div>
                  <div class="tech-case-progress"><span class="active" data-tech-progress="0"><i>1</i>Assigned</span><span data-tech-progress="1"><i>2</i>Accepted</span><span data-tech-progress="2"><i>3</i>In Progress</span><span data-tech-progress="3"><i>4</i>Completed</span></div>
                  <button class="demo-primary-action guided-target" type="button" id="demoTechnicianAction">Accept task</button>
                </div>
              </section>

              <section class="demo-dashboard-view" data-demo-view-panel="notifications">
                <div class="demo-system-head"><div><small>ADMIN DASHBOARD</small><h3>Operational Notifications</h3></div><span class="demo-live-pill" id="demoNotificationPill">NO NEW UPDATE</span></div>
                <div class="demo-notification-empty" id="demoNotificationEmpty"><span>◉</span><h4>No completed-case notification yet</h4><p>Complete the Room 305 task in the Technician Dashboard</p></div>
                <div class="demo-notification-list" id="demoNotificationList" hidden>
                  <article class="notification-complete"><span>✓</span><div><small>JUST NOW · ROOM 305</small><strong>Maintenance case completed</strong><p>Amir Hassan completed the HVAC leakage task and the case status has been updated</p></div><b>COMPLETED</b></article>
                  <article><span>↗</span><div><small>GUEST UPDATE</small><strong>Completion notification prepared</strong><p>The guest can now be informed that the maintenance issue has been resolved</p></div><b>SENT</b></article>
                </div>
              </section>

              <div class="demo-live-message" id="demoLiveMessage" aria-live="polite">Fresh demo session ready</div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="content-section value-section" id="business-value" data-section="business-value">
      <div class="section-heading value-heading reveal">
        <span class="section-number">08</span>
        <div>
          <div class="section-kicker">Business Uniqueness</div>
          <h2>Not just ticket automation. A governed maintenance intelligence loop.</h2>
          <p>SmartOps combines complaint understanding, evidence-grounded RAG-LLM reasoning, risk-aware human control and workforce-connected execution within one operational workflow.</p>
        </div>
      </div>

      <div class="value-loop-label reveal" aria-label="SmartOps governed intelligence loop">
        <span>INTEGRATED INTELLIGENCE LOOP</span>
        <strong>Understand <i>→</i> Govern <i>→</i> Execute</strong>
      </div>

      <div class="value-benefit-grid value-uniqueness-grid reveal">
        <article class="value-benefit-card value-uniqueness-card value-understand-card">
          <div class="value-card-topline"><span>01</span><small>RAG-LLM INTELLIGENCE</small></div>
          <h3>Turns maintenance issues into grounded maintenance decisions</h3>
          <p>Unstructured guest reports are classified by category, severity and priority, then enriched with retrieved troubleshooting, preventive maintenance and inspection knowledge.</p>
          <div class="value-card-tags"><span>Complaint context</span><span>Evidence retrieval</span><span>Explainable recommendation</span></div>
        </article>

        <article class="value-benefit-card value-uniqueness-card value-govern-card">
          <div class="value-card-topline"><span>02</span><small>HITL GOVERNANCE</small></div>
          <h3>Stops automation when human judgment matters</h3>
          <p>Safety-critical, low-confidence and OUT_OF_KB cases remain pending for managers to review, adjust and approve before operational assignment.</p>
          <div class="value-card-tags"><span>Risk escalation</span><span>Human approval</span><span>Decision accountability</span></div>
        </article>

        <article class="value-benefit-card value-uniqueness-card value-execute-card">
          <div class="value-card-topline"><span>03</span><small>WORKFORCE EXECUTION</small></div>
          <h3>Connects approved intelligence to accountable action</h3>
          <p>Assignments consider technician skills, availability and workload, while managers track each task from acceptance and work in progress through completion.</p>
          <div class="value-card-tags"><span>Manpower utilization</span><span>Live task progress</span><span>Closed-loop action</span></div>
        </article>
      </div>

      <div class="value-uniqueness-statement reveal">
        <span>SMARTOPS DIFFERENCE</span>
        <strong>AI understands. Humans govern. Operations move.</strong>
      </div>
    </section>

    <section class="content-section cost-section" id="cost" data-section="cost">
      <div class="section-heading reveal">
        <span class="section-number">09</span>
        <div>
          <div class="section-kicker">Cost & Deployment</div>
          <h2>Estimated hotel project cost</h2>
          <p>SmartOps uses manday-based pricing. For this hotel project site, the estimated cost includes 30 mandays for product work, 20 mandays for implementation, and RM500 monthly maintenance.</p>
        </div>
      </div>

      <div class="cost-showcase-v3 project-cost-layout reveal">
        <article class="cost-v3-card implementation project-card product-card">
          <div class="cost-v3-head">
            <span class="cost-v3-step">01</span>
            <div>
              <small>PRODUCT COST</small>
              <strong>Hotel project product work</strong>
            </div>
          </div>

          <div class="cost-v3-amount project-amount">
            <span>RM</span><strong>45,000</strong>
          </div>

          <div class="cost-v3-mini-math">RM1,500 × 30 mandays</div>

          <ul class="cost-v3-bullets project-bullets">
            <li>Knowledge base preparation</li>
            <li>Workflow and dashboard configuration</li>
            <li>System setup for hotel use case</li>
          </ul>

          <div class="cost-v3-footer-note accent-purple">Manday rate: RM1,500 / day</div>
        </article>

        <div class="cost-v3-op" aria-hidden="true">+</div>

        <article class="cost-v3-card subscription project-card implementation-card">
          <div class="cost-v3-head">
            <span class="cost-v3-step">02</span>
            <div>
              <small>IMPLEMENTATION COST</small>
              <strong>Estimated site implementation</strong>
            </div>
          </div>

          <div class="cost-v3-amount project-amount">
            <span>RM</span><strong>30,000</strong>
          </div>

          <div class="cost-v3-mini-math">RM1,500 × 20 mandays</div>

          <ul class="cost-v3-bullets project-bullets">
            <li>Testing and validation</li>
            <li>User training and onboarding</li>
            <li>Deployment and go-live support</li>
          </ul>

          <div class="cost-v3-footer-note accent-blue">Estimated implementation: 20 days</div>
        </article>

        <div class="cost-v3-op" aria-hidden="true">+</div>

        <article class="cost-v3-card total project-card maintenance-card">
          <div class="cost-v3-head total-head">
            <span class="cost-v3-step">03</span>
            <div>
              <small>MAINTENANCE</small>
              <strong>Post-deployment support</strong>
            </div>
          </div>

          <div class="cost-v3-amount project-amount total-amount">
            <span>RM</span><strong>500</strong><em>/ month</em>
          </div>

          <div class="cost-v3-total-box maintenance-box">
            <small>ANNUAL MAINTENANCE</small>
            <strong>RM 6,000</strong>
          </div>

          <div class="cost-v3-year2-note">
            <strong>Estimated monthly maintenance: RM500</strong>
            <span>Includes support, upkeep and minor system maintenance</span>
          </div>
        </article>
      </div>

      <div class="cost-v3-summary project-cost-summary reveal">
        <div class="cost-v3-summary-row startup-summary-row">
          <div class="startup-total"><small>START-UP COST</small><strong>RM 75,000</strong></div>
          <b>+</b>
          <div class="startup-recurring"><small>RECURRING COST</small><strong>RM 6,000 / year</strong></div>
        </div>
        <p>For a startup, the estimated start-up cost is MYR 75k. Recurring maintenance cost is RM6k yearly.</p>
      </div>

      <div class="cost-note reveal"><span>COST BASIS</span> MYR 75k is the estimated start-up cost, while recurring maintenance cost is RM6k yearly. For other projects, quotation is based on project scope and required mandays.</div>
    </section>



    <div class="post-demo-sequence">
    <section class="content-section sustainability-section" id="sustainability" data-section="sustainability">
      <div class="sustainability-grid-pattern" aria-hidden="true"></div>
      <div class="sustainability-glow sustainability-glow-one" aria-hidden="true"></div>
      <div class="sustainability-glow sustainability-glow-two" aria-hidden="true"></div>

      <div class="section-heading sustainability-heading reveal">
        <span class="section-number">10</span>
        <div>
          <div class="section-kicker">Sustainability Impact</div>
          <h2>Smarter operations for people, productivity and the planet</h2>
          <p>SmartOps supports sustainable maintenance through healthier teamwork, productive workflows, reliable infrastructure and responsible resource use.</p>
        </div>
      </div>

      <div class="sustainability-card-grid reveal">
        <article class="sustainability-card sustainability-card-media sdg-card-3 has-official-sdg-icon">
          <span class="sustainability-watermark" aria-hidden="true">03</span>
          <div class="sustainability-card-media-inner">
            <div class="sdg-official-icon sdg-official-icon-large">
              <img src="assets/logos/sdg-3-good-health-well-being.png" alt="SDG 3 Good Health and Well-Being">
            </div>
            <div class="sustainability-card-copy">
              <small class="sustainability-card-kicker">PEOPLE &amp; WELL-BEING</small>
              <h3>Good Health &amp; Well-Being</h3>
              <p>Clear task ownership and real-time progress reduce workplace stress and repeated follow-ups.</p>
              <div class="sustainability-tags"><span>Clear ownership</span><span>Better teamwork</span></div>
            </div>
          </div>
        </article>

        <article class="sustainability-card sustainability-card-media sdg-card-8 has-official-sdg-icon">
          <span class="sustainability-watermark" aria-hidden="true">08</span>
          <div class="sustainability-card-media-inner">
            <div class="sdg-official-icon sdg-official-icon-large">
              <img src="assets/logos/sdg-8-decent-work-economic-growth.png" alt="SDG 8 Decent Work and Economic Growth">
            </div>
            <div class="sustainability-card-copy">
              <small class="sustainability-card-kicker">WORKFORCE &amp; PRODUCTIVITY</small>
              <h3>Decent Work &amp; Economic Growth</h3>
              <p>Automated handovers and guided troubleshooting reduce repetitive coordination and improve team productivity.</p>
              <div class="sustainability-tags"><span>Better work</span><span>Higher productivity</span></div>
            </div>
          </div>
        </article>

        <article class="sustainability-card sustainability-card-media sdg-card-9 has-official-sdg-icon">
          <span class="sustainability-watermark" aria-hidden="true">09</span>
          <div class="sustainability-card-media-inner">
            <div class="sdg-official-icon sdg-official-icon-large">
              <img src="assets/logos/sdg-9-industry-innovation-infrastructure.png" alt="SDG 9 Industry, Innovation and Infrastructure">
            </div>
            <div class="sustainability-card-copy">
              <small class="sustainability-card-kicker">SYSTEMS &amp; RELIABILITY</small>
              <h3>Industry, Innovation &amp; Infrastructure</h3>
              <p>AI-supported workflows and digital task tracking improve maintenance reliability and operational efficiency.</p>
              <div class="sustainability-tags"><span>Smarter systems</span><span>Reliable operations</span></div>
            </div>
          </div>
        </article>

        <article class="sustainability-card sustainability-card-media sdg-card-12 has-official-sdg-icon">
          <span class="sustainability-watermark" aria-hidden="true">12</span>
          <div class="sustainability-card-media-inner">
            <div class="sdg-official-icon sdg-official-icon-large">
              <img src="assets/logos/sdg-12-responsible-consumption-production.png" alt="SDG 12 Responsible Consumption and Production">
            </div>
            <div class="sustainability-card-copy">
              <small class="sustainability-card-kicker">RESOURCES &amp; WASTE</small>
              <h3>Responsible Consumption &amp; Production</h3>
              <p>Earlier issue detection and preventive maintenance help reduce water, energy and material waste.</p>
              <div class="sustainability-tags"><span>Earlier action</span><span>Lower waste</span></div>
            </div>
          </div>
        </article>
      </div>

    </section>

    <section class="content-section future-vision-section" id="future-vision" data-section="future-vision">
      <div class="future-grid-pattern" aria-hidden="true"></div>
      <div class="future-orb future-orb-one" aria-hidden="true"></div>
      <div class="future-orb future-orb-two" aria-hidden="true"></div>

      <div class="section-heading future-heading reveal">
        <span class="section-number">11</span>
        <div>
          <div class="section-kicker">Future Evolution</div>
          <h2>From text-based intelligence to visual maintenance diagnosis <span class="future-h2-sub">with Vision-Language Model (VLM)</span></h2>
        </div>
      </div>

      <div class="future-diagnosis-shell reveal">
        <div class="future-panel future-text-panel">
          <div class="future-compare-label current">CURRENT</div>
          <div class="future-panel-header">
            <div><small>01 · TEXT INPUT</small><strong>SmartOps text intake</strong></div>
            <span class="future-status"><i></i> TEXT RECEIVED</span>
          </div>

          <div class="text-scene" aria-label="Illustrated text complaint intake being analysed by SmartOps">
            <div class="vlm-corner corner-tl" aria-hidden="true"></div>
            <div class="vlm-corner corner-tr" aria-hidden="true"></div>
            <div class="vlm-corner corner-bl" aria-hidden="true"></div>
            <div class="vlm-corner corner-br" aria-hidden="true"></div>
            <div class="vlm-room-tag"><b>ROOM 305</b><span>WHATSAPP · TEXT INPUT</span></div>

            <div class="text-chat-shell">
              <div class="text-chat-head"><span>Guest message</span><b>SmartOps intake</b></div>
              <div class="text-chat-bubble">
                <p>Hi, I’m in <span class="inline-detect">Room 305</span>. The <span class="inline-detect">air-conditioning</span> is <span class="inline-detect">leaking water</span> near the indoor unit.</p>
              </div>
            </div>
          </div>

          <div class="future-evidence-strip">
            <span>STRUCTURED TEXT EXTRACTED</span>
            <strong>Room 305 · HVAC issue · water leakage near indoor unit</strong>
          </div>
        </div>

        <div class="future-panel future-visual-panel future-input-panel">
          <div class="future-compare-label future">FUTURE</div>
          <div class="future-panel-header">
            <div><small>02 · IMAGE + VLM</small><strong>Visual inspection</strong></div>
            <span class="future-status"><i></i> IMAGE RECEIVED</span>
          </div>

          <div class="vlm-scene" aria-label="Illustrated Room 305 air-conditioner leakage image being scanned by a Vision-Language Model">
            <div class="vlm-corner corner-tl" aria-hidden="true"></div>
            <div class="vlm-corner corner-tr" aria-hidden="true"></div>
            <div class="vlm-corner corner-bl" aria-hidden="true"></div>
            <div class="vlm-corner corner-br" aria-hidden="true"></div>
            <div class="vlm-room-tag"><b>ROOM 305</b><span>HVAC · VISUAL INPUT</span></div>

            <div class="aircon-illustration" aria-hidden="true">
              <div class="aircon-body">
                <div class="aircon-brand">SMARTCOOL</div>
                <div class="aircon-display">18°</div>
                <div class="aircon-vent"><i></i><i></i><i></i><i></i><i></i></div>
              </div>
              <div class="aircon-pipe"></div>
              <span class="water-drop drop-one"></span>
              <span class="water-drop drop-two"></span>
              <span class="water-drop drop-three"></span>
              <div class="wet-area"></div>
            </div>

            <div class="vlm-detection detection-unit"><span>INDOOR AC UNIT</span></div>
            <div class="vlm-detection detection-leak"><span>POSSIBLE LEAKAGE POINT</span></div>
            <div class="vlm-detection detection-water"><span>WATER ACCUMULATION</span></div>
            <div class="vlm-scan-line" aria-hidden="true"><span>VLM SCANNING</span></div>
          </div>

          <div class="future-evidence-strip">
            <span>VISUAL EVIDENCE EXTRACTED</span>
            <strong>Water accumulation detected beneath the indoor AC unit</strong>
          </div>
        </div>

      </div>
    </section>


    <section class="content-section value-section" id="business-value-legacy">
      <div class="section-heading value-heading reveal">
        <span class="section-number" aria-hidden="true"></span>
        <div>
          <div class="section-kicker">Uniqueness & Business Value</div>
          <h2>One platform. One governed maintenance journey.</h2>
          <p>SmartOps AI connects every operational step—from guest reporting and issue classification to trusted retrieval, human approval and technician assignment.</p>
        </div>
      </div>

      <div class="value-benefit-grid reveal">
        <article class="value-benefit-card">
          <span>01</span>
          <small>REDUCE MANUAL WORKLOAD</small>
          <h3>Less repetitive coordination</h3>
          <p>Automates complaint routing, evidence retrieval and case preparation so SMEs rely less on manual triage.</p>
        </article>
        <article class="value-benefit-card">
          <span>02</span>
          <small>IMPROVE RESPONSE SPEED</small>
          <h3>Faster movement from report to action</h3>
          <p>Connects reporting, decision support and technician workflow within one visible operating journey.</p>
        </article>
        <article class="value-benefit-card">
          <span>03</span>
          <small>PRESERVE ORGANISATIONAL KNOWLEDGE</small>
          <h3>Reusable maintenance intelligence</h3>
          <p>Keeps troubleshooting and preventive procedures structured, searchable and available to future teams.</p>
        </article>
      </div>


      <div class="value-industries industries-section" id="industries">
      <div class="section-heading reveal">
        
        <div>
          <div class="section-kicker">Beyond Hotels</div>
          <h2>Adaptable across operational maintenance environments</h2>
          <p>The current prototype is configured for hotel operations, while the modular architecture can be adapted to other facility-based businesses.</p>
        </div>
      </div>

      <div class="industry-grid reveal">
        <article class="industry-card active">
          <div class="industry-photo"><img src="assets/photos/industry-hotel.webp" alt="Modern hotel building exterior."></div>
          <span>01</span><div class="industry-card-copy"><h3>Hotels</h3><p>Guest rooms, HVAC, plumbing, lifts, electrical and fire protection.</p><small>CURRENT PROTOTYPE</small></div>
        </article>
        <article class="industry-card">
          <div class="industry-photo"><img src="assets/photos/industry-office.webp" alt="Modern office building exterior."></div>
          <span>02</span><div class="industry-card-copy"><h3>Office Buildings</h3><p>Tenant issues, shared facilities and critical building systems.</p></div>
        </article>
        <article class="industry-card">
          <div class="industry-photo"><img src="assets/photos/industry-mall.webp" alt="Shopping centre interior with escalators and public areas."></div>
          <span>03</span><div class="industry-card-copy"><h3>Shopping Centres</h3><p>Retail units, escalators, lighting and high-traffic public areas.</p></div>
        </article>
        <article class="industry-card">
          <div class="industry-photo"><img src="assets/photos/industry-campus.webp" alt="University campus and academic buildings."></div>
          <span>04</span><div class="industry-card-copy"><h3>Campuses</h3><p>Classrooms, hostels, laboratories and shared infrastructure.</p></div>
        </article>
        <article class="industry-card">
          <div class="industry-photo"><img src="assets/photos/industry-property.webp" alt="Residential property managed as a shared facility."></div>
          <span>05</span><div class="industry-card-copy"><h3>Property Management</h3><p>Residential units, common areas and technician coordination.</p></div>
        </article>
        <article class="industry-card">
          <div class="industry-photo"><img src="assets/photos/hero-technician.webp" alt="Technician maintaining operational facility equipment."></div>
          <span>06</span><div class="industry-card-copy"><h3>Commercial Facilities</h3><p>Recurring operational issues and governed maintenance workflows.</p></div>
        </article>
      </div>
      <div class="industry-note reveal"><span>CONFIGURATION NOTE</span> Each deployment requires a domain-specific knowledge base, operational SOP configuration and workflow customisation.</div>
      </div>

    </section>
    </div>

    <section class="closing-section">
      <div class="closing-grid" aria-hidden="true"></div>
      <div class="closing-copy reveal">
        <span>SMARTOPS AI · GROUP 7</span>
        <h2>Grounded intelligence for safer,<br>more visible operational maintenance.</h2>
        <p>Hotel operations provide the current real-world demonstration. The architecture is designed to support broader maintenance environments through domain-specific configuration.</p>
        <div class="closing-actions"><a class="button button-primary" href="guided_demo.php?reset=1">Start Live Demo ↗</a><a class="button button-secondary light" href="#home">Back to Top ↑</a></div>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <p>Developed by Group 7 · Business Analytics Final Year Project · Sunway University</p>
  </footer>

  <dialog class="diagram-modal" id="diagramModal" aria-labelledby="diagramTitle">
    <div class="diagram-modal-bar"><div><small>SMARTOPS TECHNICAL DETAIL</small><strong id="diagramTitle">Detailed diagram</strong></div><button type="button" id="diagramClose" aria-label="Close diagram">×</button></div>
    <div class="diagram-modal-body"><img id="diagramImage" src="" alt=""></div>
  </dialog>

  <script src="assets/presentation.js?v=<?= e($assetVersion) ?>"></script>
<script id="smartopsRagRedesignScript">

document.addEventListener("DOMContentLoaded", function () {

    const ragSection =
        document.getElementById("technology");

    if (!ragSection) {
        return;
    }


    /* ======================================================
       CHAPTER SWITCHING
    ====================================================== */

    const chapterButtons =
        Array.from(
            ragSection.querySelectorAll(
                "[data-rag-chapter-button]"
            )
        );

    const chapters =
        Array.from(
            ragSection.querySelectorAll(
                "[data-rag-chapter]"
            )
        );

    const subchapterButtons =
        Array.from(
            ragSection.querySelectorAll(
                "[data-rag-subchapter-button]"
            )
        );

    const navigationGroups =
        Array.from(
            ragSection.querySelectorAll(
                "[data-rag-nav-group]"
            )
        );

    const llmGenerationFrame =
        document.getElementById("llmGenerationFrame");

    function setLlmGenerationSlide(index) {

        if (!llmGenerationFrame || !llmGenerationFrame.contentWindow) {
            return;
        }

        llmGenerationFrame.contentWindow.postMessage({
            type: "smartops-llm-slide",
            index: Number(index)
        }, "*");

    }


    function defaultSubchapterFor(index) {

        const targetIndex = String(index);

        if (targetIndex === "0") {
            return "1A";
        }

        if (targetIndex === "1") {
            return "2A";
        }

        if (targetIndex === "4") {
            return "4A";
        }

        return "";

    }


    function navigationIndexFor(index) {

        const targetIndex = String(index);

        return targetIndex;

    }


    function activateRagChapter(index, subchapter) {

        const targetIndex =
            String(index);

        const navigationIndex =
            navigationIndexFor(targetIndex);

        const selectedSubchapter =
            subchapter || defaultSubchapterFor(targetIndex);


        chapterButtons.forEach(function (button) {

            button.classList.toggle(
                "active",
                button.dataset.ragChapterButton === navigationIndex
            );

        });


        chapters.forEach(function (chapter) {

            chapter.classList.toggle(
                "active",
                chapter.dataset.ragChapter === targetIndex
            );

        });


        navigationGroups.forEach(function (group) {

            const activeGroup =
                (navigationIndex === "0" && group.dataset.ragNavGroup === "1") ||
                (navigationIndex === "1" && group.dataset.ragNavGroup === "2") ||
                (navigationIndex === "4" && group.dataset.ragNavGroup === "4");

            group.classList.toggle("active", activeGroup);
            group.classList.toggle("expanded", activeGroup);

            const parentButton =
                group.querySelector("[data-rag-chapter-button]");

            if (parentButton) {
                parentButton.setAttribute(
                    "aria-expanded",
                    activeGroup ? "true" : "false"
                );
            }

        });


        subchapterButtons.forEach(function (button) {

            const active =
                button.dataset.ragSubchapterButton === selectedSubchapter;

            button.classList.toggle("active", active);

            if (active) {
                button.setAttribute("aria-current", "step");
            } else {
                button.removeAttribute("aria-current");
            }

        });

        if (targetIndex === "4") {
            const slideMap = { "4A": 0, "4B": 1 };
            window.setTimeout(function () {
                setLlmGenerationSlide(slideMap[selectedSubchapter] ?? 0);
            }, 40);
        }

    }


    function scrollToRagTarget(targetId) {

        if (!targetId) {
            return;
        }

        const target =
            document.getElementById(targetId);

        if (!target) {
            return;
        }

        window.requestAnimationFrame(function () {

            const siteHeader =
                document.getElementById("siteHeader");

            const offset =
                (siteHeader ? siteHeader.offsetHeight : 0) + 24;

            const top =
                window.scrollY +
                target.getBoundingClientRect().top -
                offset;

            window.scrollTo({
                top: Math.max(0, top),
                behavior: "smooth"
            });

        });

    }


    chapterButtons.forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                const group =
                    button.closest("[data-rag-nav-group]");

                if (
                    group &&
                    button.classList.contains("active") &&
                    group.classList.contains("expanded")
                ) {
                    group.classList.remove("expanded");
                    button.setAttribute("aria-expanded", "false");
                    return;
                }

                activateRagChapter(
                    button.dataset.ragChapterButton
                );

            }
        );

    });


    subchapterButtons.forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                activateRagChapter(
                    button.dataset.ragChapterTarget,
                    button.dataset.ragSubchapterButton
                );

                if (button.dataset.ragAnchor) {
                    scrollToRagTarget(button.dataset.ragAnchor);
                }

                if (button.dataset.llmSlide) {
                    setLlmGenerationSlide(button.dataset.llmSlide);
                }

            }
        );

    });




    /* ======================================================
       RETAINED NEXT-STAGE NAVIGATION CARDS
    ====================================================== */

    const nextChapterButtons =
        Array.from(
            ragSection.querySelectorAll(
                "[data-rag-next-chapter]"
            )
        );

    nextChapterButtons.forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                const nextIndex =
                    button.dataset.ragNextChapter;

                activateRagChapter(nextIndex);

                window.requestAnimationFrame(function () {

                    const targetChapter =
                        ragSection.querySelector(
                            '[data-rag-chapter="' + nextIndex + '"]'
                        );

                    if (!targetChapter) {
                        return;
                    }

                    const siteHeader =
                        document.getElementById("siteHeader");

                    const offset =
                        (siteHeader ? siteHeader.offsetHeight : 0) + 24;

                    const top =
                        window.scrollY +
                        targetChapter.getBoundingClientRect().top -
                        offset;

                    window.scrollTo({
                        top: Math.max(0, top),
                        behavior: "smooth"
                    });

                });

            }
        );

    });


    /* ======================================================
       FRAMEWORK / VALIDATION TABS
    ====================================================== */

    const technologyTabs =
        Array.from(
            ragSection.querySelectorAll(
                ".tech-tab[data-tab]"
            )
        );

    const technologyPanels =
        Array.from(
            ragSection.querySelectorAll(
                ".tech-panel[data-panel]"
            )
        );


    technologyTabs.forEach(function (tab) {

        tab.addEventListener(
            "click",
            function () {

                const selectedTab =
                    tab.dataset.tab;


                technologyTabs.forEach(function (item) {

                    const active =
                        item.dataset.tab === selectedTab;

                    item.classList.toggle(
                        "active",
                        active
                    );

                    item.setAttribute(
                        "aria-selected",
                        active
                            ? "true"
                            : "false"
                    );

                });


                technologyPanels.forEach(function (panel) {

                    panel.classList.toggle(
                        "active",
                        panel.dataset.panel === selectedTab
                    );

                });

            }
        );

    });


    /* ======================================================
       MODALS
    ====================================================== */

    ragSection
        .querySelectorAll(
            "[data-rag-modal-open]"
        )
        .forEach(function (button) {

            button.addEventListener(
                "click",
                function (event) {

                    event.preventDefault();

                    const modal =
                        document.getElementById(
                            button.dataset.ragModalOpen
                        );

                    if (
                        modal &&
                        typeof modal.showModal === "function"
                    ) {
                        modal.showModal();
                    }

                }
            );

        });


    ragSection
        .querySelectorAll(
            "[data-rag-modal-close]"
        )
        .forEach(function (button) {

            button.addEventListener(
                "click",
                function () {

                    const modal =
                        button.closest("dialog");

                    if (modal) {
                        modal.close();
                    }

                }
            );

        });


    ragSection
        .querySelectorAll(
            "dialog.rag-modal"
        )
        .forEach(function (modal) {

            modal.addEventListener(
                "click",
                function (event) {

                    if (event.target === modal) {
                        modal.close();
                    }

                }
            );

        });


    document.addEventListener(
        "keydown",
        function (event) {

            if (event.key !== "Escape") {
                return;
            }

            ragSection
                .querySelectorAll(
                    "dialog.rag-modal[open]"
                )
                .forEach(function (modal) {

                    modal.close();

                });

        }
    );


    activateRagChapter(0);

});

</script>


<script>
(function () {
    const section = document.getElementById('llm-generation-4b');
    if (!section) return;

    const triggers = Array.from(section.querySelectorAll('[data-llm4b-control]'));
    const views = Array.from(section.querySelectorAll('[data-llm4b-view]'));
    const title = section.querySelector('#llm4bOverviewTitle');
    const back = section.querySelector('#llm4bOverviewBack');
    const stack = section.querySelector('.llm4b-stack');
    const names = {
        model: 'OUTPUT ENGINEERING',
        prompt: 'PROMPT ENGINEERING',
        context: 'CONTEXT ENGINEERING FLOW',
        harness: 'HARNESS CONTROL FLOW',
        loop: 'BOUNDED REPAIR LOOP'
    };
    let current = null;

    function showControl(control) {
        current = control || null;
        views.forEach(function (view) {
            view.classList.toggle('active', view.dataset.llm4bView === (current || 'default'));
        });
        triggers.forEach(function (trigger) {
            trigger.classList.toggle('active', trigger.dataset.llm4bControl === current);
            trigger.setAttribute('aria-pressed', String(trigger.dataset.llm4bControl === current));
        });
        if (stack) stack.dataset.activeControl = current || '';
        if (title) title.textContent = current ? names[current] : 'ENGINEERING OVERVIEW';
        if (back) back.hidden = !current;
    }

    triggers.forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            const requested = trigger.dataset.llm4bControl;
            showControl(current === requested ? null : requested);
        });
    });

    if (back) back.addEventListener('click', function () { showControl(null); });
    showControl(null);
})();
</script>

<script id="validationExperimentResultsScript">
(function () {
    const modal = document.getElementById('validationResultModal');
    const panel = document.getElementById('validationPanel');
    if (!modal || !panel) return;

    const results = {
        E2: {
            area: 'DATA & COMPLAINT INTELLIGENCE',
            title: '10% Untouched Whole-Pipeline Generalisation Test',
            summary: 'A frozen 15-row subset was processed end to end with no threshold tuning after results were observed.',
            metrics: [['15/15', 'Executed successfully'], ['93.33%', 'Classification accuracy'], ['93.33%', 'Macro-F1'], ['4/4', 'Generated outputs grounded']],
            details: '<ul><li>14 of 15 classifier predictions were correct.</li><li>Routes: 10 RETRIEVAL_HITL, 2 completed human review, 1 OUT_OF_KB and 2 auto-approved.</li><li>Four recommendations were generated; all were schema-valid and grounded.</li><li>No runtime errors were recorded.</li></ul>',
            decision: 'Use the result as an untouched operational check of the integrated classifier and pipeline.',
            caveat: 'This is a small whole-pipeline generalisation test, not a standalone classifier model-selection experiment or broad statistical proof.',
            evidence: 'data/whole_pipeline_results.jsonl; evaluation/generalisation_test_10pct_v1/evaluation/generalisation_summary.json'
        },
        E3: {
            area: 'KNOWLEDGE BASE ENGINEERING',
            title: 'Parent-Child KB Structure & Context Completeness',
            summary: 'The final KB and retrieval outputs were checked to ensure every selected parent could reconstruct a complete maintenance scenario.',
            metrics: [['294', 'Total KB rows'], ['98', 'Parent scenarios'], ['98 + 98', 'Troubleshooting + preventive'], ['100%', 'Context completeness']],
            details: '<ul><li>Each scenario contains one parent, one troubleshooting child and one preventive child.</li><li>Parent-only indexing is followed by scenario_id child lookup.</li><li>Synthetic benchmark completeness: 100% in both retrieval modes.</li><li>Real retrieval completeness: 510/510 retrieved cases.</li></ul>',
            decision: 'Retain scenario-level parent-only indexing because it preserves complete linked operational evidence after selection.',
            caveat: 'The 294 rows are structured chunks: 98 parents and 196 children, not 294 independent maintenance scenarios.',
            evidence: 'data/kb_parent_child_chunks_fixed_llm.csv; evaluation/frozen_synthetic_benchmark_v1/final_synthetic_rag_evaluation_summary.json; evaluation/rag_retrieval_validation_v1/rag_retrieval_summary.json'
        },
        E4: {
            area: 'RETRIEVAL STACK',
            title: 'Frozen Synthetic Scenario-Level RAG Benchmark',
            summary: 'Five frozen queries for each of 98 scenarios measured exact parent recovery under oracle-category and global retrieval.',
            metrics: [['490', 'Frozen queries'], ['67.35%', 'Global Hit@1'], ['82.04%', 'Global Hit@3'], ['90.00%', 'Global Hit@5']],
            details: '<ul><li>Global: MRR@5 0.7557, nDCG@5 0.7916 and category accuracy@1 95.71%.</li><li>Oracle-category: Hit@1 69.80%, Hit@3 84.90% and Hit@5 90.20%.</li><li>Context completeness was 100% in both modes.</li><li>Models: BGE-small dense retrieval, BM25 sparse retrieval and MiniLM reranking.</li></ul>',
            decision: 'Keep candidate retrieval, reranking and Gate 1 instead of trusting raw dense similarity or assuming Top-1 is always correct.',
            caveat: 'Synthetic queries provide repeatable scenario coverage but do not replace natural complaints. This frozen benchmark reranked a 30-candidate pool; the current V1.2.7 runtime uses hybrid Top-10 followed by final Top-5.',
            evidence: 'evaluation/frozen_synthetic_benchmark_v1/final_synthetic_rag_evaluation_summary.json'
        },
        E5: {
            area: 'RETRIEVAL STACK',
            title: 'Category-Filtered vs Global Retrieval',
            summary: 'The same 490 queries were run with known-category filtering and unrestricted global search.',
            metrics: [['69.80%', 'Filtered Hit@1'], ['67.35%', 'Global Hit@1'], ['84.90%', 'Filtered Hit@3'], ['82.04%', 'Global Hit@3']],
            details: '<ul><li>Filtered Hit@5: 90.20%.</li><li>Global Hit@5: 90.00%.</li><li>Global category accuracy@1 after reranking: 95.71%.</li><li>The advantage is modest but consistent at Top-1 and Top-3.</li></ul>',
            decision: 'Retain classifier-guided category filtering for supported domains while keeping the global retrieval stack robust.',
            caveat: 'Oracle-category mode uses the known correct category. It is a best-case retrieval ablation and must not be described as deployed classifier accuracy.',
            evidence: 'evaluation/frozen_synthetic_benchmark_v1/final_synthetic_rag_evaluation_summary.json'
        },
        E6: {
            area: 'RETRIEVAL STACK',
            title: 'MiniLM Cross-Encoder Reranker Effectiveness',
            summary: 'Pre-reranking and post-reranking Hit@K were compared on the same frozen candidate sets.',
            metrics: [['+7.14 pp', 'Global Hit@1'], ['+6.53 pp', 'Global Hit@3'], ['+7.35 pp', 'Global Hit@5'], ['+6.94 pp', 'Filtered Hit@1']],
            details: '<ul><li>Global Hit@1: 60.20% to 67.35%.</li><li>Global Hit@3: 75.51% to 82.04%.</li><li>Global Hit@5: 82.65% to 90.00%.</li><li>Filtered Hit@1: 62.86% to 69.80%.</li></ul>',
            decision: 'Retain the MiniLM cross-encoder because it materially improves scenario ordering after hybrid fusion.',
            caveat: 'The uplift measures ordering in the frozen 30-candidate benchmark pool. The current runtime uses hybrid Top-10 followed by final Top-5; semantic usefulness on real complaints was evaluated separately.',
            evidence: 'evaluation/frozen_synthetic_benchmark_v1/final_synthetic_rag_evaluation_summary.json'
        },
        E8: {
            area: 'RETRIEVAL STACK',
            title: 'LLM-as-a-Judge Semantic Retrieval Evaluation',
            summary: 'A structured evaluator judged selected scenarios and linked evidence against 500 real complaints.',
            metrics: [['500/500', 'Judgements completed'], ['70.2%', 'Fully relevant'], ['78.8%', 'Retrieval acceptable'], ['0%', 'Contradictions']],
            details: '<ul><li>At least partially relevant: 82.2%.</li><li>Retrieval-acceptable by category: D10 65%, D20 83%, D30 90%, D40 63%, D50 93%.</li><li>Safety-issue-missed rate: 16.2%.</li><li>D10 and D40 were the weakest categories.</li></ul>',
            decision: 'Use semantic labels to calibrate a conservative Gate 1, while keeping safety release under deterministic Gate 2.',
            caveat: 'These are AI-assisted labels, not ground truth. E10 adds stronger human evidence for the archived calibration policy; the current four-signal runtime rule still requires its own holdout run.',
            evidence: 'evaluation/rag_llm_judge_gptoss120b_full_v3/llm_judge_summary.json'
        },
        E9: {
            area: 'RETRIEVAL STACK',
            title: 'Retrieval Confidence Gate Calibration',
            summary: 'A 500-case semantic evidence set was split before calibration so threshold selection and final checking remained separate.',
            metrics: [['350', 'Calibration rows'], ['150', 'Frozen holdout rows'], ['144,000', 'Candidate rules checked'], ['≥95%', 'Calibration precision target']],
            details: '<ul><li>Candidate cut-offs were generated from score quantiles and tested only on the 350-row calibration split.</li><li>Eligible rules had to meet the precision target; the highest-coverage eligible rule was preferred.</li><li>The search did not require stronger dense or hybrid cut-offs, so the existing technical floors of 0.55 and 0.20 were retained.</li><li>Category consistency and complete parent–child context remain mandatory in the current runtime.</li></ul>',
            decision: 'Use 0.55 dense and 0.20 hybrid as minimum eligibility floors—not probabilities or a weighted confidence score.',
            caveat: 'The archived 150-row human validation also used an additional separation condition that is disabled in the current V1.2.7 runtime. Its precision figures therefore describe that historical calibrated policy, not the current four-signal gate.',
            evidence: 'evaluation/rag_confidence_calibration_v1/recommended_threshold_config.json; config/pipeline_v1_2_experimental.json'
        },
        E10: {
            area: 'RETRIEVAL STACK',
            title: 'Human Review of the Archived Calibration Policy',
            summary: 'All 150 frozen holdout rows were human-labelled without retuning the archived precision-oriented policy.',
            metrics: [['150/150', 'Human-labelled'], ['97.37%', 'Accepted precision'], ['0.67%', 'False-ready rate'], ['25.33%', 'Coverage']],
            details: '<ul><li>38 cases were accepted by Gate 1.</li><li>Human-acceptable cases: 94.</li><li>Confusion counts: TP 37, FP 1, FN 57 and TN 55.</li><li>All documented acceptance criteria passed.</li></ul>',
            decision: 'Use this result as evidence for precision-first gating and HITL, while validating the current four-signal V1.2.7 rule separately before claiming the same precision.',
            caveat: 'The 97.37% result belongs to an archived rule containing an additional separation condition. It must not be presented as measured performance of the current four-signal runtime gate.',
            evidence: 'evaluation/rag_confidence_calibration_v1/human_validation_final/human_validation_summary.json'
        },
        E11: {
            area: 'LLM REASONING & GROUNDING',
            title: '30-Case Structured Generation & Grounding Baseline',
            summary: 'Thirty RAG-ready evidence packages were generated once and checked with deterministic schema and grounding controls.',
            metrics: [['30/30', 'Generated successfully'], ['100%', 'Schema valid'], ['29/30', 'Grounded'], ['100%', 'Context sufficient']],
            details: '<ul><li>Model: Groq Llama 3.1 8B Instant.</li><li>Every response returned the required recommendation JSON structure.</li><li>Deterministic grounding passed on 29 of 30 outputs (96.67%).</li><li>The same frozen outputs were handed to E12 afterward; they were not regenerated.</li></ul>',
            decision: 'Retain the structured prompt and hard schema check, then use verification and bounded repair for the remaining unsupported case.',
            caveat: 'This experiment measures deterministic generation behaviour only. RAGAS faithfulness and answer relevancy belong to E12.',
            evidence: 'evaluation/recommendation_generation_eval_v1/recommendation_generation_summary.json'
        },
        E12: {
            area: 'LLM REASONING & GROUNDING',
            title: 'RAGAS Recommendation Evaluation',
            summary: 'The same 30 recommendations were evaluated semantically with RAGAS 0.4.3.',
            metrics: [['0.9766', 'Faithfulness'], ['0.7961', 'Answer relevancy'], ['≈1.0000', 'Context utilisation'], ['0.0234', 'Estimated unfaithfulness']],
            details: '<ul><li>30/30 RAGAS rows completed with no evaluator failures.</li><li>15 of 30 answer-relevancy scores were below 0.80.</li><li>Deterministic grounding remained 96.67%.</li><li>Evaluator: gpt-oss-120b; embeddings: BGE-small.</li></ul>',
            decision: 'Separate evidence support from direct complaint relevance: grounding was strong, while answer focus remained an improvement area.',
            caveat: 'Estimated unfaithfulness is an evaluation indicator, not a literal count of hallucinated sentences.',
            evidence: 'evaluation/ragas_recommendation_eval_v1/ragas_recommendation_summary.json'
        },
        E13: {
            area: 'LLM REASONING & GROUNDING',
            title: 'Prompt Refinement Paired Pilots',
            summary: 'Two five-case pilots tested stricter evidence constraints for tools, materials and recommendation wording.',
            metrics: [['60% → 100%', 'Grounding'], ['4 → 0', 'Unsupported claims needing removal'], ['5/5', 'V2.2 schema valid'], ['0.8541', 'V2.2 faithfulness']],
            details: '<ul><li>Prompt V2: 3/5 grounded and four unsupported tools/materials removed.</li><li>Prompt V2.2: 5/5 grounded and zero unsupported tools/materials removed.</li><li>V2.2 answer relevancy: 0.7808.</li><li>V2.2 context utilisation: approximately 1.0.</li></ul>',
            decision: 'Use stricter evidence-constrained prompting, especially exact support for tools and materials.',
            caveat: 'This is a targeted five-case pilot. Mixed RAGAS movement means it should not be claimed as broad statistical superiority.',
            evidence: 'evaluation/recommendation_generation_eval_prompt_v2_pilot/*; evaluation/recommendation_generation_eval_prompt_v2_2_pilot/*'
        },
        E17: {
            area: 'LLM REASONING & GROUNDING',
            title: 'Bounded Repair Design & Acceptance Protocol',
            summary: 'Four targeted cases define how the bounded repair path must be checked from failed support through selected-KB repair, re-verification and re-grounding.',
            metrics: [['4', 'Targeted cases defined'], ['1', 'Maximum semantic repair'], ['2', 'Mandatory post-repair checks'], ['NOT STORED', 'Live four-case result']],
            details: '<ul><li>Live-call, transport and prompt-budget hardening are treated as enabling work inside this complete-loop experiment, not separate headline experiments.</li><li>Recovery uses selected-KB facts and rejects placeholder evidence.</li><li>Every repaired output must be re-verified and re-grounded.</li><li>Persistent failure routes to HITL; critical and active-hazard cases remain under fail-closed governance.</li></ul>',
            decision: 'Allow one bounded correction opportunity, but require every repaired result to pass verification, grounding and Gate 2.',
            caveat: 'The package marks the four-case live execution as not started and contains no completed result file. The 9/9 repair and 45/45 verification/grounding figures belong only to the E21 project acceptance record.',
            evidence: 'config/complete_loop_regression_4_v1_2_7_manifest.json; FINAL_LIVE_ACCEPTANCE_STEPS_V1_2_7.md; V1_2_STATIC_TEST_REPORT.txt; PATCH_NOTES_V1_2_7_COMPLETE_LOOP.md'
        },
        E18: {
            area: 'SYSTEM, GOVERNANCE & INTEGRATION',
            title: 'Pipeline Route Regression Test',
            summary: 'Five required operational outcomes were tested individually against the frozen V1.0 governance baseline.',
            metrics: [['5/5', 'Cases passed'], ['0', 'Failed'], ['5', 'Required routes'], ['100%', 'Behavioural coverage']],
            details: '<ul><li>OUT_OF_KB.</li><li>RETRIEVAL_HITL.</li><li>GROUNDING_REVIEW.</li><li>SAFETY_REVIEW.</li><li>AUTO_APPROVED.</li></ul>',
            decision: 'Treat correct refusal and human-review routing as successful behaviour, not only automatic approval.',
            caveat: 'This is a V1.0 deterministic governance baseline, not a fresh V1.2.7 run or a measurement of production route frequency. Gate 2 behaviour remained unchanged.',
            evidence: 'evaluation/pipeline_v1_regression_v1/regression_summary.json'
        },
        E19: {
            area: 'SYSTEM, GOVERNANCE & INTEGRATION',
            title: 'FastAPI User Acceptance Testing',
            summary: 'The deployment API handover layer was tested for the outcomes required by the backend and frontend.',
            metrics: [['4/4', 'Routes passed'], ['0', 'Failed'], ['100%', 'Defined-route compatibility'], ['4', 'Operational outcomes']],
            details: '<ul><li>AUTO_APPROVED.</li><li>OUT_OF_KB.</li><li>RETRIEVAL_HITL.</li><li>SAFETY_REVIEW.</li></ul>',
            decision: 'Use the tested API outcomes to control recommendation display, review routing and unsupported-case handling.',
            caveat: 'The 4/4 UAT result belongs to the V1.0 API contract; it is not live load, penetration or production security testing.',
            evidence: 'evaluation/phase14_api_uat_summary_v1.json; docs/deployment_api_contract_v1.md'
        },
        E21: {
            area: 'SYSTEM, GOVERNANCE & INTEGRATION',
            title: 'Paired 50-Row Whole-Pipeline Acceptance',
            summary: 'The same 50-row operational set compared grounded release across V1.1, V1.2.3 and the final V1.2.7 project acceptance record.',
            metrics: [['50/50', 'V1.2.7 executed'], ['45/45', 'Verified + grounded'], ['9/9', 'Repairs successful'], ['32/50', 'Auto-approved · 64%']],
            details: '<div class="validation-result-compare"><div><strong>Version</strong><span>Grounding</span><span>Auto-release</span><span>Safety</span></div><div><strong>V1.1 RC1</strong><span>38/45 · 84.44%</span><span>26/50 · 52%</span><span>Critical auto: 0</span></div><div><strong>V1.2.3 GVR</strong><span>45/45 · 100%</span><span>31/50 · 62%</span><span>Critical + hazard auto: 0</span></div><div><strong>V1.2.7 RC1</strong><span>45/45 · 100%</span><span>32/50 · 64%</span><span>Critical + hazard auto: 0</span></div></div>',
            decision: 'Present V1.2.7 as improved grounded recoverability with unchanged fail-closed safety governance, not simply as a higher auto-approval rate.',
            caveat: 'The ZIP embeds V1.1 and V1.2.3 results. The V1.2.7 final row is the project acceptance record; the fresh V1.2.7 deployment summary is not stored in the package.',
            evidence: 'EVALUATION_BASELINE_AND_ACCEPTANCE.md; evaluation/baseline_v1_2_3_50row/deployment_summary_v1_2.json; project V1.2.7 acceptance record'
        }
    };

    const questions = {
        E2: 'Will the complete SmartOps pipeline still work on complaints it did not tune against?',
        E3: 'Can one retrieved parent reconstruct the complete corrective and preventive maintenance scenario?',
        E4: 'How accurately can SmartOps recover the known parent scenario across the full knowledge base?',
        E5: 'Does category filtering improve retrieval when the rest of the search pipeline stays unchanged?',
        E6: 'Does MiniLM improve the ordering of the same frozen hybrid candidate pool?',
        E8: 'Is the retrieved scenario semantically useful, sufficient and safe for the complaint?',
        E9: 'Which evidence-readiness signals should control whether generation is allowed?',
        E10: 'Does the frozen Gate 1 policy remain precise when people judge the evidence?',
        E11: 'Can the LLM return schema-valid recommendations that remain grounded in selected evidence?',
        E12: 'Are the same recommendations faithful, relevant and effective in their use of context?',
        E13: 'Can stronger prompt restrictions remove unsupported tools, materials and actions?',
        E17: 'Can SmartOps repair one unsupported claim and still stop safely when evidence remains insufficient?',
        E18: 'Does every supported, uncertain, unsafe or unsupported case reach the correct governed route?',
        E19: 'Can the backend and frontend reliably consume the governed SmartOps JSON response?',
        E21: 'Did the final pipeline improve grounded release while preserving zero unsafe auto-approval?'
    };

    const area = document.getElementById('validationResultArea');
    const resultId = document.getElementById('validationResultId');
    const title = document.getElementById('validationResultTitle');
    const question = document.getElementById('validationResultQuestion');
    const summary = document.getElementById('validationResultSummary');
    const metrics = document.getElementById('validationResultMetrics');
    const details = document.getElementById('validationResultDetails');
    const decision = document.getElementById('validationResultDecision');
    const caveat = document.getElementById('validationResultCaveat');
    const caveatWrap = document.getElementById('validationResultCaveatWrap');
    const evidence = document.getElementById('validationResultEvidence');

    panel.querySelectorAll('[data-validation-result]').forEach(function (button) {
        button.addEventListener('click', function () {
            const id = button.dataset.validationResult;
            const result = results[id];
            if (!result) return;
            area.textContent = id + ' · ' + result.area;
            resultId.textContent = 'E' + String(Number(id.replace('E', ''))).padStart(2, '0');
            title.textContent = result.title;
            question.textContent = questions[id] || 'What did this experiment need to prove for SmartOps?';
            summary.textContent = result.summary;
            metrics.innerHTML = result.metrics.map(function (metric) {
                return '<article><strong>' + metric[0] + '</strong><span>' + metric[1] + '</span></article>';
            }).join('');
            details.innerHTML = result.details;
            decision.textContent = result.decision;
            caveat.textContent = result.caveat || '';
            caveatWrap.hidden = !result.caveat;
            evidence.textContent = result.evidence;
            if (typeof modal.showModal === 'function') {
                modal.showModal();
                window.requestAnimationFrame(function () {
                    var shell = modal.querySelector('.validation-result-shell');
                    var content = modal.querySelector('.validation-result-content');
                    modal.scrollLeft = 0;
                    if (shell) shell.scrollLeft = 0;
                    if (content) {
                        content.scrollLeft = 0;
                        content.scrollTop = 0;
                    }
                });
            }
        });
    });
})();
</script>

<script id="validationExperimentDevelopmentScript">
(function () {
    const panel = document.getElementById('validationPanel');
    const modal = document.getElementById('validationDevelopmentModal');
    if (!panel || !modal) return;

    const developments = {
        E2: {
            area: 'DATA & COMPLAINT INTELLIGENCE',
            title: 'Developing the Untouched Generalisation Test',
            summary: 'I created a small frozen subset and passed it through the complete pipeline without changing thresholds after seeing the outcome.',
            objective: 'Check whether classification, routing, generation validation and governance still worked together on unseen complaints.',
            inputs: ['15 untouched complaints', 'Frozen classifier', 'Frozen Gate 1 policy', 'Frozen generation and Gate 2 rules'],
            flow: ['Freeze subset', 'Classify', 'Retrieve + Gate 1', 'Generate eligible cases', 'Apply Gate 2', 'Compare outcome'],
            steps: ['Selected and froze the test rows before execution.', 'Ran TF-IDF and Logistic Regression to predict the maintenance category.', 'Applied retrieval and Gate 1 so uncertain evidence did not enter generation.', 'Generated only eligible cases and validated schema plus grounding.', 'Applied deterministic Gate 2 to automatic-release and human-review outcomes.', 'Compared predictions, routes, generated outputs and runtime errors against the frozen expectations.'],
            control: 'No classifier retraining, threshold tuning or route correction was allowed after the 15 rows were exposed.',
            outcome: 'An untouched end-to-end check of whether the independently developed components generalised as one system.'
        },
        E3: {
            area: 'KNOWLEDGE BASE ENGINEERING',
            title: 'Developing the Parent–Child Knowledge Base',
            summary: 'I transformed maintenance knowledge into scenario-level evidence that can retrieve one parent and reconstruct its linked troubleshooting and preventive procedures.',
            objective: 'Preserve complete maintenance meaning while keeping retrieval focused on one searchable parent scenario instead of isolated instruction fragments.',
            inputs: ['Maintenance source records', 'Category and equipment metadata', 'Problem, symptom and failure context', 'Troubleshooting and preventive procedures'],
            flow: ['Clean + structure', 'Metadata tagging', 'Parent–child chunking', 'Assign scenario_id', 'Index parent only', 'Reconstruct children'],
            steps: ['Standardised the maintenance fields before creating the searchable scenario.', 'Tagged the Room 305 AC leakage scenario with seven controlled JSON metadata layers: hotel asset, component, failure mode, observed symptoms, possible root cause, severity and safety flag.', 'Created one searchable parent and split corrective troubleshooting and preventive evidence into two linked child records.', 'Assigned the same scenario_id to the parent, troubleshooting child and preventive child.', 'Embedded and indexed only the parent in ChromaDB while retaining BM25-searchable parent text.', 'After selecting a parent, looked up both children by scenario_id, rebuilt the complete context package and checked structural completeness.'],
            control: 'Children were never treated as independent maintenance scenarios and were never allowed to compete against their own parent during retrieval.',
            outcome: 'The scenario-based parent–child architecture and parent-only indexing method used by the live hybrid retrieval pipeline.'
        },
        E4: {
            area: 'RETRIEVAL STACK & GATE 1',
            title: 'Developing the Frozen Synthetic RAG Benchmark',
            summary: 'I created equal query coverage for every parent scenario so retrieval configurations could be compared against known ground truth.',
            objective: 'Measure exact parent-scenario recovery across the full knowledge base without category imbalance or changing test queries.',
            inputs: ['98 parent scenarios', '5 complaint variants per scenario', 'Known parent ground truth', 'Filtered and global retrieval modes'],
            flow: ['Generate equal variants', 'Freeze 490 queries', 'Run hybrid retrieval', 'Rerank candidate pool', 'Match parent ID', 'Calculate Hit@K'],
            steps: ['Created five complaint variants for each of the 98 parent scenarios.', 'Stored each complaint with its expected parent scenario_id and froze all 490 rows.', 'Ran BGE-small dense retrieval and BM25 sparse retrieval with 0.40/0.60 fusion.', 'Applied MiniLM to the frozen 30-candidate benchmark pool and retained the final Top-5.', 'Compared returned parent scenario_id values with the frozen ground truth.', 'Calculated Hit@1, Hit@3, Hit@5, MRR@5, nDCG@5 and context completeness.'],
            control: 'Every scenario received the same number of queries and both retrieval modes used the same frozen benchmark.',
            outcome: 'A repeatable retrieval benchmark used for ablation, reranker and Gate 1 development.'
        },
        E5: {
            area: 'RETRIEVAL STACK & GATE 1',
            title: 'Developing the Category-Filter Ablation',
            summary: 'I isolated the contribution of category filtering by changing only the search scope.',
            objective: 'Determine whether classifier-guided category filtering improved scenario recovery compared with searching the full knowledge base.',
            inputs: ['Same 490 frozen queries', 'Known correct category', 'Same hybrid scoring', 'Same MiniLM reranker'],
            flow: ['Run filtered search', 'Run global search', 'Keep pipeline constant', 'Compare Hit@K', 'Check category@1'],
            steps: ['Executed each query inside its known correct category as the best-case filtered condition.', 'Executed the same query against all parent scenarios as the global condition.', 'Kept fusion weights, candidate count and reranker unchanged.', 'Compared exact parent Hit@1, Hit@3 and Hit@5.', 'Measured whether the global Top-1 result still belonged to the correct maintenance category.'],
            control: 'Only the category-filter condition changed; the benchmark, retrieval models, fusion and reranking remained fixed.',
            outcome: 'Evidence for retaining supported-domain category filtering while preserving a robust global fallback stack.'
        },
        E6: {
            area: 'RETRIEVAL STACK & GATE 1',
            title: 'Developing the MiniLM Reranker Experiment',
            summary: 'I measured the candidate order before and after cross-encoder reranking on exactly the same hybrid candidate sets.',
            objective: 'Verify that MiniLM added ranking value beyond BGE-small and BM25 fusion.',
            inputs: ['Frozen hybrid candidates', 'Complaint–scenario pairs', 'MiniLM cross-encoder', 'Known parent ground truth'],
            flow: ['Create candidate set', 'Record pre-rank order', 'Score pairs with MiniLM', 'Reorder candidates', 'Compare Hit@K'],
            steps: ['Stored the candidate ranking produced by dense and BM25 fusion.', 'Paired each complaint with every candidate parent scenario.', 'Applied the MiniLM cross-encoder to score pairwise semantic relevance.', 'Sorted candidates by reranker score.', 'Compared pre-reranking and post-reranking Hit@1, Hit@3 and Hit@5.'],
            control: 'The candidate pool and query set did not change; only candidate ordering changed.',
            outcome: 'The decision to retain MiniLM as the final selection layer after hybrid fusion.'
        },
        E8: {
            area: 'RETRIEVAL STACK & GATE 1',
            title: 'Developing the LLM-as-a-Judge Review',
            summary: 'I added a structured semantic review layer because successful retrieval does not prove that the selected scenario is correct.',
            objective: 'Estimate whether each retrieved parent and its linked evidence were relevant, sufficient, non-contradictory and safety-aware.',
            inputs: ['500 real complaints', 'Selected parent context', 'Troubleshooting child', 'Preventive child', 'Structured judge rubric'],
            flow: ['Package complaint + evidence', 'Apply fixed rubric', 'Return structured judgement', 'Aggregate by category', 'Identify weak cases'],
            steps: ['Combined the complaint with the selected parent and reconstructed child evidence.', 'Asked the evaluator to score relevance, partial relevance, acceptability, contradiction and missed safety issues.', 'Required a structured output so every judgement used the same fields.', 'Aggregated outcomes overall and by maintenance category.', 'Used weak and unsafe cases as calibration evidence rather than automatic ground truth.'],
            control: 'The judge saw the same evidence package for each case and its labels were treated as AI-assisted evaluation, not human ground truth.',
            outcome: 'A semantic error analysis used to design a conservative retrieval-confidence gate.'
        },
        E9: {
            area: 'RETRIEVAL STACK & GATE 1',
            title: 'Developing Retrieval Confidence Calibration',
            summary: 'I separated threshold development from validation, searched a precision-first rule space and retained the lowest useful evidence floors.',
            objective: 'Show exactly why Dense ≥ 0.55 and Hybrid ≥ 0.20 became minimum Gate 1 requirements without presenting either value as a probability.',
            inputs: ['500 semantic evidence labels', 'Dense and hybrid retrieval scores', 'Category consistency', 'Context completeness', '95% calibration precision target'],
            flow: ['Create 350 / 150 split', 'Read four readiness signals', 'Search 144,000 rules', 'Retain 0.55 / 0.20 floors', 'Freeze Gate 1 policy'],
            steps: ['Split the 500 labelled cases into 350 calibration rows and a locked 150-row holdout using a fixed random seed and stratification.', 'Read the two score signals together with the two non-numeric evidence checks; no single weighted confidence value was calculated.', 'Generated candidate cut-offs from score quantiles, tested 144,000 combinations and kept only rules meeting at least 95% calibration precision before preferring higher coverage.', 'The search did not require stronger dense or hybrid limits, so the existing technical floors—0.55 dense and 0.20 hybrid—were retained as minimum eligibility checks.', 'Required both numerical floors, a category match and complete parent–child context before returning RAG_READY; otherwise route uncertainty to review.'],
            control: 'The holdout was never used to choose these figures. The values are technical lower bounds, not 55% and 20% confidence probabilities.',
            outcome: 'The current runtime uses an explainable four-signal Gate 1 policy: Dense ≥ 0.55 + Hybrid ≥ 0.20 + category matched + context complete. The archived human-validation rule is reported separately in E10.'
        },
        E10: {
            area: 'RETRIEVAL STACK & GATE 1',
            title: 'Reviewing the Archived Gate 1 Calibration Policy',
            summary: 'I replaced AI-assisted acceptability labels with a frozen human review set to test the historical precision-oriented calibration rule.',
            objective: 'Measure whether the archived frozen policy maintained high accepted precision when judged by people.',
            inputs: ['150 frozen holdout cases', 'Human accept/reject labels', 'Archived frozen Gate 1 rule', 'Selected retrieval evidence'],
            flow: ['Human label cases', 'Run frozen gate', 'Build confusion matrix', 'Measure precision + coverage', 'Check criteria'],
            steps: ['Human reviewers labelled all 150 frozen cases as acceptable or unacceptable evidence.', 'Ran the archived Gate 1 calibration policy on every holdout case without retuning.', 'Compared RAG_READY decisions with human labels to build TP, FP, FN and TN.', 'Calculated accepted precision, false-ready rate and automatic coverage.', 'Recorded the result as historical calibration evidence rather than attributing it to the current four-signal runtime rule.'],
            control: 'The human holdout was not used to tune the archived policy; its additional separation condition is disabled in the current V1.2.7 runtime.',
            outcome: 'Strong human evidence for the precision-first gating approach, with a clear requirement to validate the current four-signal runtime policy separately.'
        },
        E11: {
            area: 'LLM REASONING & GROUNDING',
            title: 'Developing the 30-Case Generation Quality Baseline',
            summary: 'I generated one frozen 30-case recommendation set and measured only its structured output and deterministic grounding behaviour.',
            objective: 'Confirm that the frozen prompt and Groq model could transform selected RAG evidence into machine-readable, evidence-supported recommendations.',
            inputs: ['30 RAG-ready cases', 'Complaint + linked evidence', 'Frozen structured prompt', 'Groq Llama 3.1 8B Instant', 'Recommendation JSON schema'],
            flow: ['Assemble 30 cases', 'Generate JSON', 'Validate schema', 'Check grounding', 'Record baseline'],
            steps: ['Combined each complaint with its selected parent, troubleshooting and preventive evidence.', 'Applied the frozen evidence-only prompt and called Groq Llama 3.1 8B Instant.', 'Parsed every response and validated required fields and data types.', 'Checked each actionable recommendation claim against the supplied evidence.', 'Froze the 30 outputs as the generation baseline and passed that unchanged set to E12.'],
            control: 'The selected evidence, model, prompt and output schema stayed fixed. Generation never granted operational release authority.',
            outcome: 'A clean 30-case structured-generation baseline: 30/30 generated, 100% schema-valid and 29/30 deterministically grounded.'
        },
        E12: {
            area: 'LLM REASONING & GROUNDING',
            title: 'Developing the RAGAS Semantic Evaluation',
            summary: 'I evaluated the same generated recommendations from a semantic perspective instead of relying only on deterministic checks.',
            objective: 'Separate evidence faithfulness, answer relevance and context use so each weakness could be diagnosed independently.',
            inputs: ['Same 30 complaints', 'Retrieved context', 'Generated recommendation', 'RAGAS 0.4.3', 'BGE-small embeddings'],
            flow: ['Format RAGAS rows', 'Evaluate faithfulness', 'Evaluate relevancy', 'Evaluate context use', 'Compare deterministic result'],
            steps: ['Mapped each complaint, evidence package and recommendation into the RAGAS evaluation format.', 'Used the configured evaluator to score support for generated claims.', 'Measured how directly each recommendation addressed the complaint.', 'Measured whether retrieved context was utilised.', 'Compared semantic scores with deterministic schema and grounding outcomes.', 'Reviewed low-relevancy cases as prompt-engineering opportunities.'],
            control: 'The 30 recommendations were not regenerated for RAGAS; the same outputs were reused to keep the comparison valid.',
            outcome: 'Evidence that grounding was strong while direct answer focus still required prompt refinement.'
        },
        E13: {
            area: 'LLM REASONING & GROUNDING',
            title: 'Developing the Prompt Refinement Pilots',
            summary: 'I ran paired prompt pilots on cases where unsupported tools or materials exposed a specific grounding weakness.',
            objective: 'Test whether stricter evidence constraints could remove unsupported operational details without changing the retrieval evidence.',
            inputs: ['Same five target cases', 'Same retrieved evidence', 'Prompt V2', 'Prompt V2.2', 'Same model and schema'],
            flow: ['Identify failure pattern', 'Strengthen instructions', 'Regenerate paired cases', 'Check removed claims', 'Compare quality'],
            steps: ['Selected five cases with known unsupported tools or materials.', 'Kept the complaint, retrieved evidence, model and JSON schema constant.', 'Added stronger rules requiring exact evidence support for tools, materials and actions.', 'Generated paired outputs with Prompt V2 and the stricter V2.2.', 'Validated schema, deterministic grounding and unsupported-removal counts.', 'Reviewed RAGAS movement before deciding whether to retain the stricter control.'],
            control: 'Only the prompt instruction changed in each paired pilot; the cases, evidence, model and output schema remained fixed.',
            outcome: 'The stricter evidence-constrained prompt controls adopted by the grounded generation pipeline.'
        },
        E17: {
            area: 'LLM REASONING & GROUNDING',
            title: 'Developing the Bounded Repair and Complete Loop',
            summary: 'I built one controlled correction cycle around generation, semantic verification and deterministic grounding.',
            objective: 'Recover an otherwise useful recommendation when specific unsupported claims can be corrected, while enforcing a hard stop if support still fails.',
            inputs: ['Generated JSON', 'Verifier verdict', 'Grounding verdict', 'Selected KB evidence', 'One-repair limit'],
            flow: ['Generate', 'Verify', 'Ground', 'Repair once if needed', 'Re-verify', 'Pass or fail closed'],
            steps: ['Generated one schema-valid structured recommendation from the selected evidence.', 'Checked every recommendation claim with the semantic evidence verifier.', 'Ran deterministic grounding before allowing any correction attempt.', 'Repaired only identified unsupported claims, using selected-KB facts and a one-repair maximum.', 'Re-ran schema validation, semantic verification and deterministic grounding after repair.', 'Passed supported outputs to Gate 2 and routed persistent failures to HITL.'],
            control: 'Maximum semantic repair cycles remained one; critical and active-hazard recommendations could never gain automatic authority through repair.',
            outcome: 'A four-case acceptance protocol defines the required Generate → Verify → Ground → Repair → Re-verify behaviour; the completed live four-case result is not stored in the package.'
        },
        E18: {
            area: 'SYSTEM, GOVERNANCE & INTEGRATION',
            title: 'Developing the Pipeline Route Regression',
            summary: 'I created deterministic cases for every required route so later changes could not silently alter governance behaviour.',
            objective: 'Verify that supported, uncertain, unsafe and unsupported cases reached the exact intended operational outcome.',
            inputs: ['Five route fixtures', 'Frozen Gate 1', 'Grounding verdicts', 'Safety and severity rules', 'Expected outcomes'],
            flow: ['Prepare route fixture', 'Run pipeline', 'Capture final status', 'Compare expected route', 'Assert no unsafe release'],
            steps: ['Defined one controlled case for OUT_OF_KB, RETRIEVAL_HITL, GROUNDING_REVIEW, SAFETY_REVIEW and AUTO_APPROVED.', 'Executed each fixture through the relevant pipeline gates.', 'Captured the final machine-readable route.', 'Compared actual and expected outcomes exactly.', 'Checked that blocked or review-only cases did not leak into automatic release.'],
            control: 'Success meant correct routing—including refusal and HITL—not merely producing an automatic recommendation.',
            outcome: 'A fast behavioural regression suite protecting the five governed operational routes.'
        },
        E19: {
            area: 'SYSTEM, GOVERNANCE & INTEGRATION',
            title: 'Developing FastAPI User Acceptance Testing',
            summary: 'I tested the recommendation service at the same API boundary used by the PHP backend and frontend adapter.',
            objective: 'Confirm that operational outcomes could be transmitted as stable JSON and interpreted correctly by the surrounding system.',
            inputs: ['POST /api/v1/recommendation', 'Complaint payloads', 'FastAPI response contract', 'Frontend adapter mappings'],
            flow: ['Send JSON request', 'Run SmartOps pipeline', 'Return governed JSON', 'Map frontend status', 'Assert required fields'],
            steps: ['Prepared request payloads representing the required operational routes.', 'Submitted each payload to the FastAPI REST endpoint.', 'Validated HTTP success and required response fields.', 'Checked that pipeline status, severity, approval requirement and release mode mapped correctly.', 'Confirmed AUTO_APPROVED, OUT_OF_KB, RETRIEVAL_HITL and SAFETY_REVIEW were understood by the integration layer.'],
            control: 'The API test validated the defined contract and routes; it did not substitute for load, penetration or production security testing.',
            outcome: 'A stable JSON handover contract between the backend integration service and SmartOps RAG-LLM.'
        },
        E21: {
            area: 'SYSTEM, GOVERNANCE & INTEGRATION',
            title: 'Developing the Paired 50-Row Acceptance',
            summary: 'I compared pipeline versions on the same operational set so grounding recovery and release changes could be attributed to the engineering updates.',
            objective: 'Validate the final complete loop end to end while preserving zero automatic release for critical or active-hazard cases.',
            inputs: ['Same 50 operational cases', 'V1.1 baseline', 'V1.2.3 GVR', 'V1.2.7 RC1', 'Frozen safety rules'],
            flow: ['Freeze paired set', 'Run each version', 'Verify generated cases', 'Record repairs + routes', 'Compare release', 'Check safety'],
            steps: ['Used the same 50-row acceptance set for comparable version-level outcomes.', 'Recorded execution success, generated-case verification and deterministic grounding.', 'Counted repair attempts and successful recoveries.', 'Measured automatic approval, human review and release rate.', 'Checked critical and active-hazard automatic approvals separately.', 'Compared versions as paired engineering evidence rather than independent headline percentages.'],
            control: 'The safety constraints remained unchanged: critical and active-hazard recommendations must never be automatically released.',
            outcome: 'The final acceptance story: stronger grounded recoverability and slightly higher governed release without weakening fail-closed safety.'
        }
    };

    const area = document.getElementById('validationDevelopmentArea');
    const developmentId = document.getElementById('validationDevelopmentId');
    const title = document.getElementById('validationDevelopmentTitle');
    const objective = document.getElementById('validationDevelopmentObjective');
    const developmentOutcome = document.getElementById('validationDevelopmentOutcome');
    const flow = document.getElementById('validationDevelopmentFlow');
    const flowInsightNumber = document.getElementById('validationFlowInsightNumber');
    const flowInsightTitle = document.getElementById('validationFlowInsightTitle');
    const flowInsightText = document.getElementById('validationFlowInsightText');
    const stageVisual = document.getElementById('validationStageVisual');
    const stageOutcome = document.getElementById('validationStageOutcome');
    const developmentProgress = document.getElementById('validationDevelopmentProgress');

    function escapeDevelopmentMarkup(value) {
        return String(value || '').replace(/[&<>"']/g, function (character) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[character];
        });
    }

    function compactDevelopmentText(value, maximum) {
        const text = String(value || '').replace(/\s+/g, ' ').trim();
        return text.length > maximum ? escapeDevelopmentMarkup(text.slice(0, maximum - 1).trim()) + '&hellip;' : escapeDevelopmentMarkup(text);
    }

    function renderGeneralisationStage(index) {
        const examples = [
            '<div class="novelty-paired-set"><article><strong>15</strong><span>Untouched operational cases</span></article><i>LOCKED</i><div><span>No retraining</span><span>No threshold tuning</span><span>No route correction</span></div><footer>Frozen before the first result was observed</footer></div>',
            '<div class="stage-transform"><article><small>UNSEEN COMPLAINT</small><strong>Water was leaking from the hot-water appliance.</strong><p>The original complaint and expected category stay unchanged.</p></article><i>&rarr;</i><article class="accent"><small>TF-IDF + LOGISTIC REGRESSION</small><strong>Predicted maintenance category</strong><dl><div><dt>Expected</dt><dd>D30 HVAC</dd></div><div><dt>Predicted</dt><dd>D20 Plumbing</dd></div><div><dt>Audit</dt><dd>Recorded mismatch</dd></div></dl></article></div>',
            '<div class="novelty-gate-signals"><article><small>DENSE SCORE</small><strong>Measured</strong></article><article><small>HYBRID SCORE</small><strong>Measured</strong></article><article><small>CATEGORY CONSISTENCY</small><strong>Required</strong></article><article><small>CONTEXT COMPLETENESS</small><strong>Required</strong></article><footer>Frozen Gate 1 &rarr; RAG_READY, RETRIEVAL_HITL or OUT_OF_KB</footer></div>',
            '<div class="novelty-json-card"><header><span>{ }</span><strong>Eligible recommendation only</strong></header><pre>{\n  "scenario_summary": "...",\n  "recommended_actions": [...],\n  "evidence": [...],\n  "context_sufficient": true\n}</pre></div>',
            '<div class="stage-decision-map"><article><small>VALIDATED OUTPUT</small><strong>Schema + grounding</strong><span>+</span><strong>Severity + safety flags</strong></article><i>&rarr;</i><article class="check"><b>&#10003;</b><small>GATE 2</small><strong>Governed release</strong></article><i>&rarr;</i><div><span class="pass">AUTO-APPROVED</span><span class="review">HUMAN REVIEW</span><span class="stop">BLOCKED</span></div></div>',
            '<div class="novelty-criteria"><article><b>&#10003;</b><span><strong>15/15 executed</strong><small>No runtime failure in the frozen run</small></span></article><article><b>&#10003;</b><span><strong>14/15 category outcomes correct</strong><small>Other and OUT_OF_KB are treated as the same unsupported outcome</small></span></article><article><b>&#10003;</b><span><strong>4/4 generated outputs valid and grounded</strong><small>Only eligible cases entered generation</small></span></article><footer>Decision: use as a small end-to-end generalisation check, not a population-level accuracy claim.</footer></div>'
        ];
        return examples[Math.min(index, examples.length - 1)];
    }

    function renderCategoryAblationStage(index) {
        const examples = [
            '<div class="novelty-paired-set"><article><strong>490</strong><span>Same frozen benchmark queries</span></article><i>SPLIT INTO</i><div><span>Oracle-category search</span><span>Global search</span><span>Same expected parent IDs</span></div><footer>No query or ground-truth change between conditions</footer></div>',
            '<div class="novelty-version-lanes"><article><b>FILTERED</b><span>Search only the known correct maintenance category</span></article><article><b>GLOBAL</b><span>Search all 98 parent scenarios without category restriction</span></article><article><b>COMPARE</b><span>Exact parent recovery at Hit@1, Hit@3 and Hit@5</span></article></div>',
            '<div class="novelty-criteria"><article><b>&#10003;</b><span><strong>Same BGE-small + BM25 retrieval</strong><small>Dense and sparse models unchanged</small></span></article><article><b>&#10003;</b><span><strong>Same 0.40 / 0.60 fusion</strong><small>Scoring weights unchanged</small></span></article><article><b>&#10003;</b><span><strong>Same MiniLM reranker</strong><small>Candidate ordering method unchanged</small></span></article><footer>Controlled change: only the category search scope differs.</footer></div>',
            '<div class="novelty-metric-bars"><article><small>ORACLE-CATEGORY</small><div><span style="--value:69.8%"><b>Hit@1</b><em>69.80%</em></span><span style="--value:84.9%"><b>Hit@3</b><em>84.90%</em></span><span style="--value:90.2%"><b>Hit@5</b><em>90.20%</em></span></div></article><article><small>GLOBAL</small><div><span style="--value:67.35%"><b>Hit@1</b><em>67.35%</em></span><span style="--value:82.04%"><b>Hit@3</b><em>82.04%</em></span><span style="--value:90%"><b>Hit@5</b><em>90.00%</em></span></div></article></div>',
            '<div class="novelty-loop-outcome"><article class="pass"><b>95.71%</b><strong>GLOBAL CATEGORY@1</strong><span>The unrestricted Top-1 still usually belonged to the correct domain</span></article><article class="stop"><b>!</b><strong>MODEST FILTER UPLIFT</strong><span>Oracle filtering is a best-case ablation, not classifier accuracy</span></article><footer><span>Keep category routing</span><span>Retain robust global fallback</span><span>Do not overstate causality</span></footer></div>'
        ];
        return examples[Math.min(index, examples.length - 1)];
    }

    function renderSemanticJudgeStage(index) {
        const examples = [
            '<div class="stage-transform"><article><small>REAL COMPLAINT</small><strong>The air conditioner is leaking water.</strong><p>Room 305 &middot; D30 HVAC</p></article><i>&rarr;</i><article class="accent"><small>EVIDENCE PACKAGE</small><dl><div><dt>Parent</dt><dd>Indoor AC Water Leakage</dd></div><div><dt>Children</dt><dd>Troubleshooting + preventive</dd></div><div><dt>Cases</dt><dd>500</dd></div></dl></article></div>',
            '<div class="novelty-verifier-table"><header><strong>Fixed semantic rubric</strong><span>Every case uses the same judgement fields</span></header><div><span>Question</span><span>What it checks</span><span>Output</span></div><div><strong>Relevant?</strong><span>Scenario matches complaint</span><b>YES / PARTIAL / NO</b></div><div><strong>Acceptable?</strong><span>Evidence can support action</span><b>TRUE / FALSE</b></div><div><strong>Safety missed?</strong><span>Important hazard absent</span><b>TRUE / FALSE</b></div></div>',
            '<div class="novelty-json-card"><header><span>{ }</span><strong>Structured judgement</strong></header><pre>{\n  "fully_relevant": true,\n  "partially_relevant": true,\n  "retrieval_acceptable": true,\n  "contradiction": false,\n  "safety_issue_missed": false\n}</pre></div>',
            '<div class="novelty-metric-bars"><article><small>OVERALL SEMANTIC RESULT</small><div><span style="--value:70.2%"><b>Fully relevant</b><em>70.2%</em></span><span style="--value:82.2%"><b>At least partial</b><em>82.2%</em></span><span style="--value:78.8%"><b>Acceptable</b><em>78.8%</em></span></div></article><article><small>QUALITY RISKS</small><div><span style="--value:0%"><b>Contradiction</b><em>0%</em></span><span style="--value:16.2%"><b>Safety issue missed</b><em>16.2%</em></span><span style="--value:100%"><b>Completed</b><em>500/500</em></span></div></article></div>',
            '<div class="novelty-loop-outcome"><article class="pass"><b>D30/D50</b><strong>STRONGER CATEGORIES</strong><span>Retrieval acceptable: D30 90%, D50 93%</span></article><article class="stop"><b>D10/D40</b><strong>WEAKER CATEGORIES</strong><span>Retrieval acceptable: D10 65%, D40 63%</span></article><footer><span>AI-assisted labels only</span><span>Used for error analysis</span><span>Human validation remains E10</span></footer></div>'
        ];
        return examples[Math.min(index, examples.length - 1)];
    }

    function renderRagasStage(index) {
        const examples = [
            '<div class="novelty-paired-set"><article><strong>30</strong><span>Frozen outputs from E11</span></article><i>REUSED AS-IS</i><div><span>Complaint</span><span>Retrieved evidence</span><span>Generated recommendation</span></div><footer>No regeneration and no second dataset</footer></div>',
            '<div class="novelty-verifier-table"><header><strong>Faithfulness</strong><span>Are recommendation claims supported by retrieved evidence?</span></header><div><span>Input</span><span>Evaluation</span><span>Meaning</span></div><div><strong>Recommendation claims</strong><span>Compared with context</span><b>0.9766</b></div></div>',
            '<div class="novelty-verifier-table"><header><strong>Answer relevancy</strong><span>Does the recommendation directly address the complaint?</span></header><div><span>Input</span><span>Evaluation</span><span>Meaning</span></div><div><strong>Complaint + answer</strong><span>Semantic focus</span><b>0.7961</b></div></div>',
            '<div class="novelty-verifier-table"><header><strong>Context utilisation</strong><span>Did the response make effective use of supplied RAG evidence?</span></header><div><span>Input</span><span>Evaluation</span><span>Meaning</span></div><div><strong>Evidence + answer</strong><span>Context use</span><b>&asymp; 1.0000</b></div></div>',
            '<div class="novelty-metric-bars"><article><small>RAGAS SEMANTIC VIEW</small><div><span style="--value:97.66%"><b>Faithfulness</b><em>0.9766</em></span><span style="--value:79.61%"><b>Answer relevancy</b><em>0.7961</em></span><span style="--value:100%"><b>Context utilisation</b><em>&asymp;1.0</em></span></div></article><article><small>E11 DETERMINISTIC VIEW</small><div><span style="--value:100%"><b>Schema</b><em>100%</em></span><span style="--value:96.67%"><b>Grounding</b><em>96.67%</em></span><span style="--value:100%"><b>Context sufficient</b><em>100%</em></span></div></article></div>'
        ];
        return examples[Math.min(index, examples.length - 1)];
    }

    function renderPromptPilotStage(index) {
        const examples = [
            '<div class="novelty-verifier-table"><header><strong>Five targeted failure cases</strong><span>Same complaints and retrieved evidence</span></header><div><span>Observed issue</span><span>Evidence status</span><span>Action</span></div><div><strong>Unsupported tool</strong><span>Not in selected KB</span><b>REMOVE</b></div><div><strong>Unsupported material</strong><span>Not in selected KB</span><b>REMOVE</b></div></div>',
            '<div class="novelty-criteria"><article><b>01</b><span><strong>Use supplied evidence only</strong><small>No general maintenance additions</small></span></article><article><b>02</b><span><strong>Exact support for tools and materials</strong><small>Omit anything absent from context</small></span></article><article><b>03</b><span><strong>Keep the same JSON schema</strong><small>Prompt wording changes; interface does not</small></span></article><footer>Controlled change: evidence restrictions become stricter.</footer></div>',
            '<div class="novelty-version-lanes"><article><b>PROMPT V2</b><span>Initial evidence-constrained pilot on five cases</span></article><article><b>PROMPT V2.2</b><span>Stricter exact-support rules on the same five cases</span></article><article><b>FIXED</b><span>Evidence, Groq model and JSON schema</span></article></div>',
            '<div class="novelty-verifier-table"><header><strong>Unsupported-detail check</strong><span>Count claims that the validator had to remove</span></header><div><span>Version</span><span>Grounded</span><span>Claims needing removal</span></div><div><strong>Prompt V2</strong><span>3/5 &middot; 60%</span><b class="fail">4</b></div><div><strong>Prompt V2.2</strong><span>5/5 &middot; 100%</span><b>0</b></div></div>',
            '<div class="novelty-loop-outcome"><article class="pass"><b>100%</b><strong>DETERMINISTIC GROUNDING</strong><span>V2.2 passed all five targeted cases</span></article><article class="stop"><b>5</b><strong>SMALL PILOT</strong><span>Mixed RAGAS movement prevents a broad superiority claim</span></article><footer><span>Retain stricter support rules</span><span>Do not generalise beyond pilot</span><span>Feed into E17</span></footer></div>'
        ];
        return examples[Math.min(index, examples.length - 1)];
    }

    function renderApiUatStage(index) {
        const examples = [
            '<div class="stage-api-flow"><article><small>PHP BACKEND REQUEST</small><strong>Complaint payload</strong><code>{ room_id, complaint_text }</code></article><i>&rarr;</i><article class="endpoint"><small>FASTAPI REST API</small><strong>Recommendation service</strong><code>POST /api/v1/recommendation</code></article><i>&rarr;</i><article><small>SMARTOPS</small><strong>Governed pipeline</strong><code>classification + RAG + gates</code></article></div>',
            '<div class="novelty-json-card"><header><span>POST</span><strong>/api/v1/recommendation</strong></header><pre>{\n  "room_id": "305",\n  "complaint_text": "The air conditioner is leaking water."\n}</pre></div>',
            '<div class="novelty-json-card"><header><span>{ }</span><strong>Governed response contract</strong></header><pre>{\n  "pipeline_status": "COMPLETED_HUMAN_REVIEW",\n  "retrieval_status": "RAG_READY",\n  "approval_status": "HUMAN_APPROVAL_REQUIRED",\n  "recommendation_state": "HUMAN_REVIEW_ONLY",\n  "severity_level": "HIGH"\n}</pre></div>',
            '<div class="governance-route-fixtures"><header><small>FOUR REQUIRED API OUTCOMES</small><strong>Backend and frontend must interpret each route</strong></header><div><span class="approved">AUTO_APPROVED</span><span class="unsupported">OUT_OF_KB</span><span class="review">RETRIEVAL_HITL</span><span class="safety">SAFETY_REVIEW</span></div><footer>Each fixture checks HTTP success, required fields and status mapping.</footer></div>',
            '<div class="novelty-safety-proof"><header><strong>API handover acceptance</strong></header><div><article><small>ROUTES PASSED</small><strong>4/4</strong></article><article><small>MAPPING FAILURES</small><strong>0</strong></article><article class="result"><small>CONTRACT COMPATIBILITY</small><strong>100%</strong></article></div><footer>&#10003; This validates defined response compatibility, not production load or security.</footer></div>'
        ];
        return examples[Math.min(index, examples.length - 1)];
    }

    function renderGenerationStage(index) {
        const examples = [
            '<div class="novelty-paired-set"><article><strong>30</strong><span>RAG-ready complaint + evidence packages</span></article><i>&rarr;</i><div><span>Frozen structured prompt</span><span>Groq Llama 3.1 8B Instant</span><span>Recommendation JSON schema</span></div><footer>E11 measures generation and deterministic grounding only</footer></div>',
            '<div class="novelty-json-card"><header><span>{ }</span><strong>Groq Llama 3.1 8B Instant</strong></header><pre>{\n  "scenario_summary": "Indoor AC water leakage",\n  "likely_issue": "Condensate drainage issue",\n  "recommended_actions": [...],\n  "safety_precautions": [...],\n  "preventive_actions": [...],\n  "evidence": [...]\n}</pre></div>',
            '<div class="novelty-acceptance-counts"><article><small>GENERATED</small><strong>30/30</strong></article><article><small>SCHEMA VALID</small><strong>30/30</strong></article><article><small>CONTEXT SUFFICIENT</small><strong>30/30</strong></article><article><small>GENERATION ERRORS</small><strong>0</strong></article></div>',
            '<div class="novelty-grounding-check"><article><small>SELECTED KB FACTS</small><strong>Parent + troubleshooting + preventive</strong></article><i>&rarr;</i><article><small>DETERMINISTIC CHECK</small><strong>Every actionable claim supported?</strong></article><i>&rarr;</i><div><span>29 PASS</span><span class="fail">1 FAIL</span></div></div>',
            '<div class="novelty-loop-outcome"><article class="pass"><b>&#10003;</b><strong>29/30 GROUNDED</strong><span>Every output was schema-valid and context-sufficient</span></article><article class="stop"><b>1</b><strong>UNSUPPORTED OUTPUT FOUND</strong><span>The failed case becomes evidence for verification and repair</span></article><footer><span>30 outputs frozen</span><span>Passed unchanged to E12</span><span>No operational authority granted</span></footer></div>'
        ];
        return examples[Math.min(index, examples.length - 1)];
    }

    function renderKnowledgeStage(index) {
        const examples = [
            '<div class="stage-transform"><article><small>RAW MAINTENANCE RECORD</small><strong>Aircond water leakage</strong><p>D3030 cooling-system record with corrective, preventive, verification and source evidence.</p></article><i>&rarr;</i><article class="accent"><small>STANDARDISED SCENARIO</small><dl><div><dt>Category</dt><dd>D30 HVAC</dd></div><div><dt>Component</dt><dd>D3030 Cooling Generating Systems</dd></div><div><dt>Failure mode</dt><dd>Chilled Water Systems</dd></div></dl></article></div>',
            '<div class="stage-seven-layer-json"><header><div><small>ROOM 305 COMPLAINT</small><strong>“The air conditioner is leaking water.”</strong></div><span><b>SCENARIO</b>D3030_chilled_water_systems_aircond_water_leakage</span></header><div class="seven-layer-layout"><ol><li><b>01</b><span>Hotel asset</span></li><li><b>02</b><span>Component</span></li><li><b>03</b><span>Failure mode</span></li><li><b>04</b><span>Observed symptoms</span></li><li><b>05</b><span>Possible root cause</span></li><li><b>06</b><span>Severity</span></li><li><b>07</b><span>Safety flag</span></li></ol><pre><code>{\n  <i>"hotel_asset"</i>: <em>"D30 HVAC"</em>,\n  <i>"component"</i>: <em>"D3030 Cooling Generating Systems"</em>,\n  <i>"failure_mode"</i>: <em>"Chilled Water Systems"</em>,\n  <i>"observed_symptoms"</i>: <em>"Aircond water leakage"</em>,\n  <i>"possible_root_cause"</i>: <em>"Not available in pilot stage"</em>,\n  <i>"severity"</i>: <em>"high"</em>,\n  <i>"safety_flag"</i>: <strong>true</strong>\n}</code></pre></div><footer><span>7 / 7 metadata layers populated</span><span>Exact package values</span><span>Ready for parent indexing</span></footer></div>',
            '<div class="stage-family-tree"><article class="parent"><small>SEARCHABLE PARENT</small><strong>Indoor AC Water Leakage</strong></article><span></span><div><article><small>LINKED CHILD</small><strong>Troubleshooting</strong><p>Detect the leak, isolate it and perform a pressure test.</p></article><article><small>LINKED CHILD</small><strong>Preventive</strong><p>Inspect drain lines, filters, controls and electrical connections.</p></article></div></div>',
            '<div class="stage-record-table"><table><thead><tr><th>Record</th><th>Type</th><th>scenario_id</th></tr></thead><tbody><tr><td>Indoor AC Water Leakage</td><td><span>Parent</span></td><td><code>D3030_chilled_water_systems_aircond_water_leakage</code></td></tr><tr><td>Drainage inspection</td><td>Troubleshooting</td><td><code>D3030_chilled_water_systems_aircond_water_leakage</code></td></tr><tr><td>Preventive drainage care</td><td>Preventive</td><td><code>D3030_chilled_water_systems_aircond_water_leakage</code></td></tr></tbody></table></div>',
            '<div class="stage-index-diagram"><article class="indexed"><small>INDEXED</small><strong>Parent scenario</strong><span>Dense vector + BM25 text</span></article><i>&rarr;</i><article class="store"><b>DB</b><strong>ChromaDB + BM25</strong><span>One searchable scenario</span></article><aside><small>LINKED, NOT INDEXED</small><span>Troubleshooting child</span><span>Preventive child</span></aside></div>',
            '<div class="stage-reconstruction"><article class="selected"><small>SELECTED PARENT</small><strong>Indoor AC Water Leakage</strong><code>D3030_chilled_water_systems_aircond_water_leakage</code></article><div class="scenario-link"><span></span><b>scenario_id lookup</b><span></span></div><div class="reconstructed"><article><small>CORRECTIVE CONTEXT</small><strong>Troubleshooting child</strong></article><article><small>PREVENTIVE CONTEXT</small><strong>Preventive child</strong></article></div><footer><b>&#10003;</b> Complete evidence package reconstructed</footer></div>'
        ];
        return examples[Math.min(index, examples.length - 1)];
    }

    function renderSyntheticBenchmarkStage(index) {
        const examples = [
            '<div class="benchmark-coverage-example"><div class="novelty-equation"><article><strong>98</strong><span>Known parent scenarios</span></article><b>&times;</b><article><strong>5</strong><span>Ways a guest may describe each problem</span></article><b>=</b><article class="result"><strong>490</strong><span>Frozen benchmark queries</span></article></div><div class="benchmark-variant-story"><article><small>ONE KNOWN CORRECT PARENT</small><strong>Indoor AC Water Leakage</strong><code>D3030_chilled_water_systems_aircond_water_leakage</code></article><i>TESTED AS</i><div><span>I noticed water leaking from the air conditioning unit in my room.</span><span>Water leaking from aircond in room.</span><span>Water is leaking from the chilled water system of the air conditioning unit.</span></div></div><footer>These are actual frozen benchmark variants; every one keeps the same expected parent scenario_id.</footer></div>',
            '<div class="novelty-dataset-table"><header><span>FROZEN_SYNTHETIC_BENCHMARK_V1</span><b>Ground truth locked before testing</b></header><table><thead><tr><th>Variant</th><th>Complaint</th><th>Expected parent</th><th>Mode</th></tr></thead><tbody><tr><td>V2_01</td><td>I noticed water leaking from the air conditioning unit in my room</td><td>D3030_chilled_water_systems_aircond_water_leakage</td><td>Filtered + Global</td></tr><tr><td>V2_03</td><td>Water leaking from aircond in room</td><td>D3030_chilled_water_systems_aircond_water_leakage</td><td>Filtered + Global</td></tr><tr><td>V2_01</td><td>The hot water pressure in the shower is very low</td><td>D2020_d2022_hot_water_service_low_hot_water_pressure</td><td>Filtered + Global</td></tr></tbody></table></div>',
            '<div class="novelty-hybrid-flow"><article><b>D</b><small>DENSE</small><strong>BGE-small</strong><span>Semantic similarity</span></article><i>+</i><article><b>K</b><small>SPARSE</small><strong>BM25</strong><span>Keyword matching</span></article><i>&rarr;</i><article class="fusion"><small>WEIGHTED FUSION</small><strong>0.40 / 0.60</strong><span>One parent-candidate list</span></article></div>',
            '<div class="novelty-rank-shift"><section><small>HYBRID ORDER · ACTUAL V2_03 CASE</small><ol><li><b>1</b>Indoor AC water leakage</li><li><b>2</b>Room not cold + hissing</li><li><b>3</b>Leakage from heater</li></ol></section><i>&rarr; MiniLM &rarr;</i><section class="after"><small>RERANKED TOP-5</small><ol><li><b>1</b>Indoor AC water leakage <em>Selected</em></li><li><b>2</b>Room not cold + hissing</li><li><b>3</b>Aircon temperature keeps changing</li></ol></section></div>',
            '<div class="novelty-id-match"><article><small>GROUND TRUTH</small><code>D3030_chilled_water_systems_aircond_water_leakage</code></article><i>&harr;</i><article><small>RETURNED PARENT</small><code>D3030_chilled_water_systems_aircond_water_leakage</code></article><strong>&#10003; EXACT PARENT MATCH</strong></div>',
            '<div class="novelty-metric-bars"><article><small>GLOBAL</small><div><span style="--value:67.35%"><b>Hit@1</b><em>67.35%</em></span><span style="--value:82.04%"><b>Hit@3</b><em>82.04%</em></span><span style="--value:90%"><b>Hit@5</b><em>90.00%</em></span></div></article><article><small>ORACLE-CATEGORY</small><div><span style="--value:69.8%"><b>Hit@1</b><em>69.80%</em></span><span style="--value:84.9%"><b>Hit@3</b><em>84.90%</em></span><span style="--value:90.2%"><b>Hit@5</b><em>90.20%</em></span></div></article></div>'
        ];
        return examples[Math.min(index, examples.length - 1)];
    }

    function renderRerankerStage(index) {
        const examples = [
            '<div class="novelty-candidate-strip"><article><b>01</b><strong>Parent A</strong><span>Hybrid 0.84</span></article><article><b>02</b><strong>Parent B</strong><span>Hybrid 0.81</span></article><article><b>03</b><strong>Parent C</strong><span>Hybrid 0.77</span></article><article><b>04</b><strong>Parent D</strong><span>Hybrid 0.73</span></article><article><b>05</b><strong>Parent E</strong><span>Hybrid 0.69</span></article></div>',
            '<div class="novelty-rank-ledger"><header><strong>Same candidate pool</strong><span>Order recorded before reranking</span></header><div><b>1</b><span>Condensate drain blockage</span><em>Hybrid rank</em></div><div><b>2</b><span>Indoor AC water leakage</span><em>Correct parent</em></div><div><b>3</b><span>Cooling coil issue</span><em>Hybrid rank</em></div></div>',
            '<div class="novelty-pair-score"><article><small>COMPLAINT</small><strong>“The air conditioner is leaking water.”</strong></article><i>+</i><article><small>CANDIDATE PARENT</small><strong>Indoor AC Water Leakage</strong></article><i>&rarr;</i><article class="score"><small>MINILM PAIR SCORE</small><strong>Semantic relevance</strong></article></div>',
            '<div class="novelty-rank-shift"><section><small>BEFORE RERANKING</small><ol><li><b>1</b>Candidate A</li><li><b>2</b>Correct parent</li><li><b>3</b>Candidate C</li></ol></section><i>&rarr; MiniLM &rarr;</i><section class="after"><small>AFTER RERANKING</small><ol><li><b>1</b>Correct parent <em>Selected</em></li><li><b>2</b>Candidate A</li><li><b>3</b>Candidate C</li></ol></section></div>',
            '<div class="novelty-uplift-chart"><article><small>GLOBAL HIT@1</small><div><span style="--value:60.2%">Before <b>60.20%</b></span><span class="after" style="--value:67.35%">After <b>67.35%</b></span></div><strong>+7.14 pp</strong></article><article><small>GLOBAL HIT@5</small><div><span style="--value:82.65%">Before <b>82.65%</b></span><span class="after" style="--value:90%">After <b>90.00%</b></span></div><strong>+7.35 pp</strong></article></div>'
        ];
        return examples[Math.min(index, examples.length - 1)];
    }

    function renderConfidenceCalibrationStage(index) {
        const examples = [
            '<div class="novelty-calibration-split"><article class="source"><small>SEMANTIC EVIDENCE POOL</small><strong>500 cases</strong><p>Each retrieved evidence package had a structured acceptability label.</p></article><i>&rarr;</i><section><article class="calibration"><b>350</b><strong>Calibration rows</strong><span>Allowed to influence threshold selection</span></article><article class="holdout"><b>150</b><strong>Frozen holdout rows</strong><span>Locked before the search began</span></article></section><footer><b>Fair-test rule</b><span>Fixed seed + stratified split. The holdout could not be used to choose 0.55 or 0.20.</span></footer></div>',
            '<div class="novelty-calibration-signals"><header><small>ONE RETRIEVED PARENT</small><strong>Read four independent evidence signals</strong><p>Gate 1 does not average these into one confidence percentage.</p></header><section><article class="dense"><b>01</b><small>SEMANTIC MATCH</small><strong>Dense score</strong><span>Meaning similarity between complaint and parent</span></article><article class="hybrid"><b>02</b><small>FUSED RETRIEVAL</small><strong>Hybrid score</strong><span>Dense + BM25 evidence after fusion</span></article><article class="category"><b>03</b><small>ROUTING CHECK</small><strong>Category matched</strong><span>Selected parent agrees with classification</span></article><article class="context"><b>04</b><small>EVIDENCE CHECK</small><strong>Context complete</strong><span>Parent + troubleshooting + preventive child</span></article></section></div>',
            '<div class="novelty-calibration-search"><header><small>PRECISION-FIRST SEARCH</small><strong>Test candidate rules on the 350 calibration rows</strong></header><div class="search-flow"><article><b>01</b><strong>Generate cut-offs</strong><span>Score quantiles from the observed calibration distribution</span></article><i>&rarr;</i><article><b>02</b><strong>Run candidate rules</strong><span>Compare each rule with semantic acceptability labels</span></article><i>&rarr;</i><article><b>03</b><strong>Keep precise rules</strong><span>Eligible only when calibration precision is at least 95%</span></article><i>&rarr;</i><article class="selected"><b>04</b><strong>Prefer coverage</strong><span>Among eligible rules, retain the one that safely accepts more cases</span></article></div><footer><span><b>&ge;95%</b> precision target</span><span><b>350</b> tuning rows only</span><span><b>0</b> holdout rows consulted</span></footer></div>',
            '<div class="novelty-calibration-floors"><header><small>WHY THESE TWO FIGURES?</small><strong>The search did not require stronger dense or hybrid cut-offs</strong><p>SmartOps therefore retained its existing low technical floors instead of inventing higher numbers.</p></header><section><article class="dense"><small>DENSE ELIGIBILITY FLOOR</small><strong>&ge; 0.55</strong><div><span>Existing development floor</span><i>&rarr;</i><b>Retained</b></div><p>Rejects a candidate with very weak semantic similarity.</p></article><article class="hybrid"><small>HYBRID ELIGIBILITY FLOOR</small><strong>&ge; 0.20</strong><div><span>Existing development floor</span><i>&rarr;</i><b>Retained</b></div><p>Rejects a candidate with insufficient fused dense + BM25 evidence.</p></article></section><footer><b>Important</b><span>0.55 is not “55% confidence” and 0.20 is not “20% confidence”. They are minimum score cut-offs on different scales.</span></footer></div>',
            '<div class="novelty-calibration-policy"><header><small>CURRENT V1.2.7 GATE 1 POLICY</small><strong>Every requirement must pass</strong></header><section class="requirements"><article><b>&ge;0.55</b><span>Dense score</span></article><i>+</i><article><b>&ge;0.20</b><span>Hybrid score</span></article><i>+</i><article><b>&#10003;</b><span>Category matched</span></article><i>+</i><article><b>&#10003;</b><span>Context complete</span></article></section><div class="policy-routes"><article class="ready"><small>ALL PASS</small><strong>RAG_READY</strong><span>Generation may begin</span></article><article class="review"><small>SUPPORTED BUT UNCERTAIN</small><strong>RETRIEVAL_HITL</strong><span>Human review required</span></article><article class="stop"><small>UNSUPPORTED CATEGORY</small><strong>OUT_OF_KB</strong><span>Generation does not run</span></article></div><footer>E10 reports historical validation of an archived calibration rule; it is not a performance claim for this current four-signal policy.</footer></div>'
        ];
        return examples[Math.min(index, examples.length - 1)];
    }

    function renderHumanGateStage(index) {
        const examples = [
            '<div class="novelty-human-review"><header><b>150</b><div><small>FROZEN HOLDOUT CASES</small><strong>Human evidence review</strong></div></header><div><article><span>&#10003;</span><strong>Acceptable evidence</strong><small>Relevant and sufficient</small></article><article><span>&times;</span><strong>Reject evidence</strong><small>Incorrect or insufficient</small></article></div></div>',
            '<div class="novelty-gate-signals"><article><small>ARCHIVED POLICY</small><strong>Frozen before review</strong></article><article><small>HUMAN LABEL</small><strong>Accept / reject</strong></article><article><small>EXTRA HISTORICAL CONDITION</small><strong>Used in this result</strong></article><article><small>CURRENT RUNTIME</small><strong>Condition disabled</strong></article><footer>The 97.37% result validates the archived policy, not today\'s four-signal V1.2.7 rule.</footer></div>',
            '<div class="novelty-confusion-matrix"><header><span></span><strong>Human accept</strong><strong>Human reject</strong></header><div><strong>Gate ready</strong><article class="tp"><b>37</b><small>True positive</small></article><article class="fp"><b>1</b><small>False ready</small></article></div><div><strong>Gate review</strong><article><b>57</b><small>False negative</small></article><article><b>55</b><small>True negative</small></article></div></div>',
            '<div class="novelty-gate-results"><article><small>ACCEPTED PRECISION</small><strong>97.37%</strong><span style="--value:97.37%"></span></article><article><small>FALSE-READY RATE</small><strong>0.67%</strong><span class="danger" style="--value:.67%"></span></article><article><small>AUTOMATIC COVERAGE</small><strong>25.33%</strong><span style="--value:25.33%"></span></article></div>',
            '<div class="novelty-criteria"><article><b>&#10003;</b><span><strong>High accepted precision</strong><small>37 of 38 ready cases human-acceptable</small></span></article><article><b>&#10003;</b><span><strong>Low false-ready exposure</strong><small>Only 1 of 150 cases incorrectly ready</small></span></article><article><b>!</b><span><strong>Historical result only</strong><small>The current four-signal runtime policy needs a separate holdout run</small></span></article><footer>Decision: retain precision-first gating and HITL, without transferring the archived percentage to the current rule.</footer></div>'
        ];
        return examples[Math.min(index, examples.length - 1)];
    }

    function renderRepairLoopStage(index) {
        const examples = [
            '<div class="novelty-json-card"><header><span>{ }</span><strong>Generated recommendation</strong></header><pre>{\n  "recommended_actions": [...],\n  "safety_precautions": [...],\n  "evidence": [...]\n}</pre></div>',
            '<div class="novelty-verifier-table"><header><strong>Semantic claim verification</strong><span>Every claim checked against selected evidence</span></header><div><span>Claim</span><span>Evidence support</span><span>Verdict</span></div><div><strong>Inspect condensate drain</strong><span>Troubleshooting child</span><b>PASS</b></div><div><strong>Replace compressor</strong><span>No selected evidence</span><b class="fail">FAIL</b></div></div>',
            '<div class="novelty-grounding-check"><article><small>SELECTED KB FACTS</small><strong>Parent + troubleshooting + preventive</strong></article><i>&rarr;</i><article><small>DETERMINISTIC CHECK</small><strong>Claims grounded in supplied evidence?</strong></article><i>&rarr;</i><div><span>PASS</span><span class="fail">REPAIR</span></div></div>',
            '<div class="novelty-repair-once"><article class="unsupported"><small>UNSUPPORTED CLAIM</small><strong>Replace compressor</strong></article><i>&rarr;</i><article class="repair"><small>SELECTED-KB RECOVERY</small><strong>Use a leak detector, isolate the leak and pressure-test</strong></article><footer><b>1</b> Maximum semantic repair cycle</footer></div>',
            '<div class="novelty-reverify"><article><b>01</b><strong>Schema valid</strong><span>&#10003;</span></article><i>&rarr;</i><article><b>02</b><strong>Semantic verification</strong><span>&#10003;</span></article><i>&rarr;</i><article><b>03</b><strong>Grounding check</strong><span>&#10003;</span></article></div>',
            '<div class="novelty-loop-outcome"><article class="pass"><b>4</b><strong>TARGET CASES DEFINED</strong><span>The acceptance manifest covers pass, repair, re-check and fail-closed behaviour</span></article><article class="stop"><b>1</b><strong>HARD REPAIR LIMIT</strong><span>Persistent failure routes to HITL instead of looping again</span></article><footer><span>Live four-case result not stored</span><span>Re-verify + re-ground required</span><span>E21 owns final acceptance figures</span></footer></div>'
        ];
        return examples[Math.min(index, examples.length - 1)];
    }

    function renderPairedAcceptanceStage(index) {
        const examples = [
            '<div class="novelty-paired-set"><article><strong>50</strong><span>Same operational cases</span></article><i>&rarr;</i><div><span>V1.1 RC1</span><span>V1.2.3 GVR</span><span>V1.2.7 RC1</span></div><footer>One frozen paired acceptance set</footer></div>',
            '<div class="novelty-version-lanes"><article><b>V1.1</b><span>Baseline generation</span></article><article><b>V1.2.3</b><span>Generate + verify + repair</span></article><article><b>V1.2.7</b><span>Complete bounded loop</span></article></div>',
            '<div class="novelty-acceptance-counts"><article><small>EXECUTED</small><strong>50/50</strong></article><article><small>GENERATED CASES</small><strong>45/45</strong></article><article><small>VERIFIED</small><strong>45/45</strong></article><article><small>GROUNDED</small><strong>45/45</strong></article></div>',
            '<div class="novelty-repair-routing"><article><small>REPAIR ATTEMPTS</small><strong>9</strong></article><i>&rarr;</i><article class="pass"><small>SUCCESSFUL RECOVERIES</small><strong>9/9</strong></article><i>&rarr;</i><article><small>GOVERNED ROUTE</small><strong>32 auto / 18 review</strong></article></div>',
            '<div class="novelty-version-chart"><article><small>GROUNDING VALID</small><div><span style="--value:84.44%"><b>V1.1</b><em>84.44%</em></span><span style="--value:100%"><b>V1.2.7</b><em>100%</em></span></div></article><article><small>AUTO-RELEASE</small><div><span style="--value:52%"><b>V1.1</b><em>52%</em></span><span style="--value:64%"><b>V1.2.7</b><em>64%</em></span></div></article></div>',
            '<div class="novelty-safety-proof"><header><strong>Safety preserved while grounded release improved</strong></header><div><article><small>CRITICAL AUTO-APPROVED</small><strong>0</strong></article><article><small>ACTIVE HAZARD AUTO-APPROVED</small><strong>0</strong></article><article class="result"><small>FINAL GROUNDED OUTPUTS</small><strong>45/45</strong></article></div><footer>&#10003; Fail-closed governance remained unchanged.</footer></div>'
        ];
        return examples[Math.min(index, examples.length - 1)];
    }

    function renderGovernanceStage(index) {
        const examples = [
            '<div class="governance-route-fixtures"><header><small>FIVE CONTROLLED CASES</small><strong>One fixture for every governed outcome</strong></header><div><span class="unsupported">OUT_OF_KB</span><span class="review">RETRIEVAL_HITL</span><span class="review">GROUNDING_REVIEW</span><span class="safety">SAFETY_REVIEW</span><span class="approved">AUTO_APPROVED</span></div><footer>Success means the correct route - including refusal and human review.</footer></div>',
            '<div class="novelty-calibration-policy"><header><small>CORRECT GOVERNANCE SEQUENCE</small><strong>Gate 1 decides whether generation may begin</strong></header><section class="requirements"><article><b>01</b><span>Complaint</span></article><i>&rarr;</i><article><b>G1</b><span>Evidence readiness</span></article><i>&rarr;</i><article><b>&#10003;</b><span>RAG_READY only</span></article><i>&rarr;</i><article><b>LLM</b><span>Generate + verify + ground</span></article></section><div class="policy-routes"><article class="stop"><small>BEFORE THE LLM</small><strong>OUT_OF_KB</strong><span>Unsupported; generation stops</span></article><article class="review"><small>BEFORE THE LLM</small><strong>RETRIEVAL_HITL</strong><span>Evidence requires human review</span></article><article class="ready"><small>AFTER GATE 2</small><strong>AUTO / GROUNDING / SAFETY</strong><span>Release or governed review</span></article></div><footer>OUT_OF_KB and RETRIEVAL_HITL never receive a generated recommendation.</footer></div>',
            '<div class="governance-status-board"><article><small>EXPECTED ROUTE</small><strong>SAFETY_REVIEW</strong><p>High-risk maintenance evidence requires human authority.</p></article><i>&harr;</i><article class="actual"><small>SMARTOPS OUTPUT</small><strong>SAFETY_REVIEW</strong><p>Frontend adapter receives the same governed status.</p></article><footer><b>&#10003;</b> Expected and actual route match</footer></div>',
            '<div class="novelty-criteria"><article><b>&#10003;</b><span><strong>5/5 V1.0 route fixtures passed</strong><small>Every baseline case reached its exact expected outcome</small></span></article><article><b>&#10003;</b><span><strong>Refusal counted as correct behaviour</strong><small>OUT_OF_KB never entered generation</small></span></article><article><b>&#10003;</b><span><strong>Review routes remained controlled</strong><small>Uncertain evidence never became automatic release</small></span></article><footer>This is the frozen Gate 2 baseline; V1.2.7 did not change its governance rules.</footer></div>',
            '<div class="novelty-safety-proof"><header><strong>Fail-closed governance assertion</strong></header><div><article><small>WRONG ROUTE</small><strong>0</strong></article><article><small>UNSAFE AUTO-RELEASE</small><strong>0</strong></article><article class="result"><small>ROUTES PASSED</small><strong>5/5</strong></article></div><footer>&#10003; Human review and refusal are successful controlled outcomes.</footer></div>'
        ];
        return examples[Math.min(index, examples.length - 1)];
    }

    function renderDevelopmentStage(item, id, index) {
        if (id === 'E2') return renderGeneralisationStage(index);
        if (id === 'E3') return renderKnowledgeStage(index);
        if (id === 'E4') return renderSyntheticBenchmarkStage(index);
        if (id === 'E5') return renderCategoryAblationStage(index);
        if (id === 'E6') return renderRerankerStage(index);
        if (id === 'E8') return renderSemanticJudgeStage(index);
        if (id === 'E9') return renderConfidenceCalibrationStage(index);
        if (id === 'E10') return renderHumanGateStage(index);
        if (id === 'E11') return renderGenerationStage(index);
        if (id === 'E12') return renderRagasStage(index);
        if (id === 'E13') return renderPromptPilotStage(index);
        if (id === 'E17') return renderRepairLoopStage(index);
        if (id === 'E18') return renderGovernanceStage(index);
        if (id === 'E19') return renderApiUatStage(index);
        if (id === 'E21') return renderPairedAcceptanceStage(index);
        const label = item.flow[index] || 'Development stage';
        const description = item.steps[Math.min(index, item.steps.length - 1)] || item.objective;
        const inputOne = item.inputs[index % item.inputs.length] || item.inputs[0] || 'Controlled input';
        const inputTwo = item.inputs[(index + 1) % item.inputs.length] || item.inputs[1] || 'Frozen rule';
        const lower = (label + ' ' + description).toLowerCase();
        const experimentNumber = Number(id.replace('E', ''));
        const projectContext = experimentNumber <= 2
            ? 'Guest complaint data to controlled SmartOps route'
            : experimentNumber === 3
                ? 'Room 305 - D30 HVAC - Indoor AC water leakage'
                : experimentNumber <= 10
                    ? 'Complaint to parent scenario to linked maintenance context'
                    : experimentNumber <= 17
                        ? 'Selected RAG evidence to verified recommendation JSON'
                        : 'Governed JSON to backend integration to operational action';

        if (/api|request|endpoint|json|response|map|transport|http/.test(lower)) {
            return '<div class="stage-api-flow"><article><small>REQUEST</small><strong>' + escapeDevelopmentMarkup(inputOne) + '</strong><code>{ complaint, context }</code></article><i>&rarr;</i><article class="endpoint"><small>CONTROLLED SERVICE</small><strong>' + escapeDevelopmentMarkup(label) + '</strong><code>POST /api/v1/recommendation</code></article><i>&rarr;</i><article><small>RESPONSE</small><strong>Governed JSON</strong><code>{ status, route, evidence }</code></article></div>';
        }
        if (/repair|retry|re-verify|loop|repeat|fail closed/.test(lower)) {
            return '<div class="stage-loop-diagram"><div><article><b>01</b><strong>Generate</strong></article><i>&rarr;</i><article><b>02</b><strong>Verify</strong></article><i>&rarr;</i><article class="decision"><b>?</b><strong>Supported?</strong></article></div><div class="loop-branches"><span class="pass">YES &rarr; PASS</span><span class="repair">NO &rarr; REPAIR ONCE &rarr; RE-VERIFY</span></div><p><b>Hard stop:</b> unresolved evidence routes to human review.</p></div>';
        }
        if (/compare|calculate|measure|score|evaluate|judge|hit@|aggregate|record|run each version/.test(lower)) {
            return '<div class="stage-comparison-chart"><div class="chart-bars"><article style="--bar:48%"><span></span><strong>Prepare</strong><small>' + escapeDevelopmentMarkup(inputOne) + '</small></article><article style="--bar:73%"><span></span><strong>Execute</strong><small>' + escapeDevelopmentMarkup(label) + '</small></article><article style="--bar:100%"><span></span><strong>Compare</strong><small>Evidence against the fixed condition</small></article></div><footer><span>Same inputs</span><span>Controlled change</span><span>Comparable evidence</span></footer></div>';
        }
        if (/gate|route|release|safety|ground|verify|validate|check|assert|classif/.test(lower)) {
            return '<div class="stage-decision-map"><article><small>EVIDENCE</small><strong>' + escapeDevelopmentMarkup(inputOne) + '</strong><span>+</span><strong>' + escapeDevelopmentMarkup(inputTwo) + '</strong></article><i>&rarr;</i><article class="check"><b>&#10003;</b><small>CONTROL</small><strong>' + escapeDevelopmentMarkup(label) + '</strong></article><i>&rarr;</i><div><span class="pass">PASS</span><span class="review">HUMAN REVIEW</span><span class="stop">FAIL CLOSED</span></div></div>';
        }
        if (/clean|normalise|structure|metadata|assign|extract|compact|prepare|freeze|load/.test(lower)) {
            return '<div class="stage-before-after"><article><small>BEFORE</small><strong>' + escapeDevelopmentMarkup(inputOne) + '</strong><div><span>Unstructured field</span><span>Mixed wording</span><span>Not comparison-ready</span></div></article><i>&rarr;</i><article class="after"><small>AFTER ' + String(index + 1).padStart(2, '0') + '</small><strong>' + escapeDevelopmentMarkup(label) + '</strong><div><span>&#10003; Consistent fields</span><span>&#10003; Controlled labels</span><span>&#10003; Ready for testing</span></div></article></div>';
        }
        return '<div class="stage-project-workbench"><header><span>SMARTOPS PROJECT CONTEXT</span><strong>' + escapeDevelopmentMarkup(projectContext) + '</strong></header><div><article><b>01</b><small>CONTROLLED INPUT</small><strong>' + escapeDevelopmentMarkup(inputOne) + '</strong><p>' + escapeDevelopmentMarkup(inputTwo) + '</p></article><i>&rarr;</i><article class="action"><b>' + String(index + 1).padStart(2, '0') + '</b><small>DEVELOPMENT ACTION</small><strong>' + escapeDevelopmentMarkup(label) + '</strong><p>' + compactDevelopmentText(description, 150) + '</p></article></div><footer><b>STAGE OUTPUT</b><span>Evidence from this step becomes the controlled input to the next SmartOps stage.</span></footer></div>';
    }

    function getStageMeaning(item, id, index) {
        const label = String(item.flow[index] || '').toLowerCase();
        const step = String(item.steps[Math.min(index, item.steps.length - 1)] || '').toLowerCase();
        const text = label + ' ' + step;
        if (id === 'E10') return 'This keeps human judgement separate from threshold tuning and makes clear that the result belongs to the archived calibration policy.';
        if (id === 'E17') return 'SmartOps gets one controlled correction opportunity; unresolved evidence still stops for human review.';
        if (id === 'E18') return 'This proves that correct refusal and human review are successful governed outcomes, not pipeline failures.';
        if (id === 'E19') return 'This keeps the governed SmartOps decision consistent when it moves through the FastAPI contract into the operational platform.';
        if (id === 'E21') return 'This keeps the case set fixed so changes in grounding, repair and release can be attributed to the pipeline version.';
        if (/variant|query/.test(text) && /generate|create|freeze/.test(text)) return 'Different ways of describing the same maintenance problem are tested against one known correct scenario.';
        if (/clean|normalise|metadata|structure|field|label/.test(text)) return 'This makes inconsistent maintenance information understandable and comparable before SmartOps uses it.';
        if (/filter|retrieve|search|candidate|select parent/.test(text)) return 'This narrows the search to maintenance evidence that is relevant to the guest complaint.';
        if (/rerank|score pairs|reorder/.test(text)) return 'This moves the most relevant parent scenario toward the top without changing the candidate set.';
        if (/repair|retry|re-verify|loop/.test(text)) return 'SmartOps gets one controlled correction opportunity; unresolved evidence still stops for human review.';
        if (/gate|threshold|ready|route/.test(text)) return 'This prevents uncertain or incomplete evidence from being sent automatically to the LLM.';
        if (/generate|prompt|json/.test(text)) return 'This turns selected evidence into a structured recommendation, but it does not grant authority to release it.';
        if (/verify|ground|claim|faithful/.test(text)) return 'This checks that every recommendation claim can be traced back to the selected maintenance evidence.';
        if (/api|endpoint|response|map|frontend|service/.test(text)) return 'This keeps the governed SmartOps decision consistent when it moves into the operational platform.';
        if (/safety|release|approval|blocked/.test(text)) return 'This preserves human control whenever severity, safety or evidence quality makes automatic release inappropriate.';
        if (/compare|measure|calculate|evaluate|audit|check/.test(text)) return 'This converts the controlled run into evidence that can support a design decision without overstating the result.';
        if (/freeze|load|prepare|assemble/.test(text)) return 'This fixes the starting condition so later comparisons remain fair and repeatable.';
        return 'This stage produces controlled evidence for the next SmartOps decision.';
    }

    function selectDevelopmentStage(item, id, index, card) {
        flow.querySelectorAll('.validation-development-flow-node').forEach(function (node) { node.classList.remove('active'); });
        if (card) card.classList.add('active');
        flowInsightNumber.textContent = String(index + 1).padStart(2, '0');
        flowInsightTitle.textContent = item.flow[index] || 'Development stage';
        flowInsightText.textContent = item.steps[Math.min(index, item.steps.length - 1)] || item.objective;
        developmentProgress.textContent = 'Stage ' + String(index + 1).padStart(2, '0') + ' of ' + String(item.flow.length).padStart(2, '0');
        stageVisual.innerHTML = renderDevelopmentStage(item, id, index);
        stageOutcome.textContent = getStageMeaning(item, id, index);
    }

    function resetModalScroll() {
        window.requestAnimationFrame(function () {
            const shell = modal.querySelector('.validation-development-shell');
            const content = modal.querySelector('.validation-development-content');
            modal.scrollLeft = 0;
            if (shell) shell.scrollLeft = 0;
            if (content) {
                content.scrollLeft = 0;
                content.scrollTop = 0;
            }
        });
    }

    function openDevelopment(id) {
        const item = developments[id];
        if (!item) return;
        const experimentNumber = Number(id.replace('E', ''));
        const areaKey = experimentNumber <= 2 ? 'data' : experimentNumber === 3 ? 'knowledge' : experimentNumber <= 10 ? 'retrieval' : experimentNumber <= 17 ? 'generation' : 'system';
        modal.dataset.developmentArea = areaKey;
        area.textContent = id + ' · ' + item.area;
        developmentId.textContent = 'E' + String(experimentNumber).padStart(2, '0');
        title.textContent = item.title;
        objective.textContent = item.objective;
        developmentOutcome.textContent = item.outcome;
        flow.replaceChildren.apply(flow, item.flow.reduce(function (nodes, label, index) {
            const card = document.createElement('button');
            card.type = 'button';
            card.className = 'validation-development-flow-node';
            const number = document.createElement('b');
            const text = document.createElement('strong');
            number.textContent = String(index + 1).padStart(2, '0');
            text.textContent = label;
            card.append(number, text);
            card.addEventListener('click', function () {
                selectDevelopmentStage(item, id, index, card);
            });
            nodes.push(card);
            if (index < item.flow.length - 1) {
                const arrow = document.createElement('i');
                arrow.setAttribute('aria-hidden', 'true');
                arrow.textContent = '→';
                nodes.push(arrow);
            }
            return nodes;
        }, []));
        const firstFlowNode = flow.querySelector('.validation-development-flow-node');
        selectDevelopmentStage(item, id, 0, firstFlowNode);
        if (typeof modal.showModal === 'function') {
            modal.showModal();
            resetModalScroll();
        }
    }

    panel.querySelectorAll('.validation-experiment-card').forEach(function (card) {
        const resultButton = card.querySelector('[data-validation-result]');
        if (!resultButton) return;
        const id = resultButton.dataset.validationResult;
        const actions = document.createElement('div');
        actions.className = 'validation-experiment-actions';
        const developmentButton = document.createElement('button');
        developmentButton.type = 'button';
        developmentButton.className = 'validation-development-button';
        developmentButton.dataset.validationDevelopment = id;
        developmentButton.innerHTML = 'View development <span aria-hidden="true">&nearr;</span>';
        developmentButton.addEventListener('click', function () { openDevelopment(id); });
        actions.append(developmentButton, resultButton);
        card.appendChild(actions);
    });

    panel.querySelectorAll('[data-feature-development]').forEach(function (button) {
        button.addEventListener('click', function () {
            openDevelopment(button.dataset.featureDevelopment);
        });
    });

})();
</script>

</body>
</html>
