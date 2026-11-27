<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--ink:#2b1a14;--muted:#765f55;--line:#e5e5e5;--bg:#fff;--soft:#fff6d6;
--red:#b71c1c;--red-dark:#7f0f0f;--yellow:#ffc21a;--orange:#ef6c00;--accent:var(--red);--danger:#9b1c1c;--ok:#1f6b3a;
}
*{box-sizing:border-box}
html{scroll-behavior:smooth}
body{margin:0;font-family:Poppins,system-ui,-apple-system,"Segoe UI",Roboto,sans-serif;color:var(--ink);background:var(--bg);line-height:1.6}
a{color:inherit}
h1,h2,h3{line-height:1.25;margin:0 0 .6rem}
h1,h2{color:var(--red-dark)}
.container{max-width:1100px;margin:0 auto;padding:1.5rem 1rem 3rem}
.muted{color:var(--muted);font-size:.9rem}
.section{margin:3rem 0;scroll-margin-top:90px}
.section>h2,.section .row-between h2{font-size:1.6rem}
.section>h2::after,.section .row-between h2::after{content:"";display:block;width:56px;height:4px;margin-top:.35rem;background:var(--yellow)}
.row-between{display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap}

/* nav */
.nav{display:flex;align-items:center;gap:1.5rem;padding:.8rem max(1rem,calc((100% - 1068px)/2));background:var(--red);border-bottom:4px solid var(--yellow);flex-wrap:wrap;position:sticky;top:0;z-index:20;color:#fff}
.logo{font-weight:800;text-decoration:none;padding:.4rem 1rem;border-radius:8px;background:var(--yellow);color:var(--red-dark)}
.nav nav{display:flex;gap:1.3rem;flex:1;flex-wrap:wrap}
.nav nav a{text-decoration:none;color:#ffe9e0;font-weight:500;border-bottom:3px solid transparent}
.nav nav a:hover,.nav nav a.on{color:var(--yellow);border-bottom-color:var(--yellow)}
.nav>a:not(.logo):not(.btn){margin-left:auto;text-decoration:none;color:#fff}
.nav .btn-dark{background:var(--yellow);border-color:var(--yellow);color:var(--red-dark)}

/* buttons & forms */
.btn{display:inline-block;padding:.55rem 1.2rem;border:2px solid var(--red);border-radius:8px;background:#fff;color:var(--red);text-decoration:none;text-align:center;cursor:pointer;font:inherit;font-weight:600}
.btn:hover{filter:brightness(.95)}
.btn-dark{background:var(--accent);color:#fff}
.btn-sm{padding:.2rem .8rem;font-size:.85rem}
.btn-block{display:block;width:100%}
.btn[disabled],.btn.off{opacity:.55;pointer-events:none;border-color:#999;color:#666}
input,select,textarea{width:100%;padding:.6rem .8rem;border:1px solid #d9b98c;border-radius:10px;font:inherit;background:#fff;color:var(--ink)}
input:focus,select:focus,textarea:focus{outline:3px solid rgba(255,194,26,.55);border-color:var(--orange)}
input[type=radio]{accent-color:var(--red)}
textarea{min-height:90px;resize:vertical}
label{display:block;font-weight:600;margin:.8rem 0 .25rem}
.radio{display:flex;gap:.5rem;align-items:center;font-weight:400;margin:.3rem 0}
.radio input{width:auto}
.hp{position:absolute;left:-9999px}

/* cards */
.card{border:1px solid var(--line);border-radius:10px;padding:1.1rem;background:#fff}
.grid{display:grid;gap:1.1rem}
.g4{grid-template-columns:repeat(4,1fr)}
.g3{grid-template-columns:repeat(3,1fr)}
.g2{grid-template-columns:1fr 1fr}
.g4>.card:not(.menu-card):not(.stat){border-top:5px solid var(--yellow)}
.ph{background:var(--soft);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--red-dark);aspect-ratio:4/3}
.thumb{width:100%;aspect-ratio:4/3;object-fit:cover;border-radius:12px}
.menu-card{display:flex;flex-direction:column;text-align:center}
.menu-card h3{font-size:1.05rem;margin:.7rem 0 .2rem}
.menu-card>div:last-child{margin-top:auto!important;padding-top:.5rem}
.price{margin:.2rem 0 .4rem;color:var(--red);font-weight:800;font-size:1.1rem}
.st-ok{color:var(--ok);font-size:.85rem;font-weight:600}.st-no{color:var(--danger);font-size:.85rem;font-weight:600}

/* hero */
.hero{position:relative;background:var(--red);border-radius:10px;min-height:360px;overflow:hidden}
.slide{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:1.5rem 1.5rem 2.5rem;color:#fff;opacity:0;visibility:hidden;transition:opacity .6s,visibility .6s}
.slide.on{opacity:1;visibility:visible}
.slide h1{font-size:2.4rem;font-weight:800;color:#fff;max-width:760px}
.slide p{font-size:1.05rem;margin:0 0 1.4rem}
.slide .btn{border-color:#fff;background:transparent;color:#fff;margin:.25rem}
.slide .btn-dark{background:var(--yellow);border-color:var(--yellow);color:var(--red-dark)}
.dots{position:absolute;bottom:.9rem;width:100%;text-align:center}
.dot{display:inline-block;width:10px;height:10px;border-radius:99px;margin:0 3px;background:rgba(255,255,255,.5)}
.dot.on{background:var(--yellow)}

/* map, tables, pills, alerts */
.map{border:4px solid var(--yellow);border-radius:10px;min-height:240px;background:#fff1cc;overflow:hidden}
.map iframe{width:100%;height:100%;min-height:240px;border:0}
table{width:100%;border-collapse:collapse}
th,td{text-align:left;padding:.65rem .6rem;border-bottom:1px solid var(--line);vertical-align:top}
th{background:var(--soft);color:var(--red-dark)}
.table-wrap{overflow-x:auto}
.pill{display:inline-block;border:1px solid var(--red);border-radius:8px;padding:.15rem .8rem;font-size:.85rem;text-decoration:none;color:var(--red);background:#fff}
.pill.on{background:var(--red);color:#fff}
.filters{display:flex;gap:.6rem;flex-wrap:wrap;align-items:center;margin-bottom:1rem}
.filters form{flex:1;min-width:200px}
.alert{padding:.7rem 1rem;border-radius:12px;margin:1rem 0;border:1px solid}
.alert-error{background:#fdecec;border-color:var(--danger);color:var(--danger)}
.alert-success{background:#e9f7ee;border-color:var(--ok);color:var(--ok)}
.pager{display:flex;gap:.4rem;justify-content:center;margin-top:1.5rem}
.pager a,.pager span{width:36px;height:36px;border:1px solid var(--red);color:var(--red);border-radius:50%;display:flex;align-items:center;justify-content:center;text-decoration:none}
.pager .on{background:var(--red);color:#fff}.pager .dis{opacity:.35}

/* FAQ */
details.faq{background:#fff;border:1px solid var(--line);border-left:6px solid var(--yellow);border-radius:12px;padding:.85rem 1rem;margin-bottom:.7rem}
details.faq[open]{border-left-color:var(--red)}
details.faq summary{font-weight:600;cursor:pointer}
details.faq p{margin:.6rem 0 0}

/* order form */
.item-row{display:grid;grid-template-columns:1fr auto auto auto auto;gap:.8rem;align-items:center;padding:.6rem 0;border-bottom:1px solid var(--line)}
.qty{display:flex;align-items:center;gap:.4rem}
.qty button{width:34px;height:34px;border:0;background:var(--yellow);color:var(--red-dark);border-radius:50%;cursor:pointer;font-size:1.1rem;font-weight:700}
.qty input{width:64px;text-align:center}
.total{display:flex;justify-content:space-between;font-weight:700;font-size:1.15rem;margin:.6rem 0;color:var(--red)}

/* footer */
.footer{background:var(--red-dark);color:#fff;border-top:6px solid var(--yellow);padding:2rem 1rem 5rem}
.footer .in{max-width:1100px;margin:0 auto;display:flex;justify-content:space-between;gap:2rem;flex-wrap:wrap}
.footer strong{color:var(--yellow)}
.footer .muted{color:#f3d2c8}
.footer a{display:block;text-decoration:none;color:#f3d2c8}
.footer a:hover{color:var(--yellow)}
.wa-float{position:fixed;right:16px;bottom:16px;z-index:30}
.btn-dark.wa-float{background:#128c4a;border-color:#fff;color:#fff}

/* admin */
.admin{display:flex;min-height:100vh}
.side{width:220px;background:var(--red-dark);color:#fff;border-right:5px solid var(--yellow);padding:1rem .8rem;flex-shrink:0}
.side .logo{display:block;text-align:center;margin-bottom:1rem}
.side a,.side button.lnk{display:block;padding:.5rem .7rem;text-decoration:none;border:0;border-radius:10px;background:none;font:inherit;text-align:left;width:100%;cursor:pointer;color:inherit}
.side a:not(.logo):hover,.side button.lnk:hover{background:rgba(255,255,255,.12)}
.side a.logo{background:var(--yellow);color:var(--red-dark)}
.side a.on,.side a.on:not(.logo):hover{background:var(--yellow);color:var(--red-dark);font-weight:700}
.side .muted{color:#f3d2c8}
.side hr{border:0;border-top:1px solid rgba(255,255,255,.25);margin:1rem 0}
.main{flex:1;padding:1.5rem;min-width:0}
.stat{border-top:5px solid var(--yellow)}
.stat b{display:block;font-size:2rem;color:var(--red)}
.login-box{max-width:420px;margin:3rem auto;border-top:6px solid var(--red)}
.mini-form{display:inline}

@media(max-width:800px){
 .g4,.g3,.g2{grid-template-columns:1fr 1fr}
 .grid[style]{grid-template-columns:minmax(0,1fr)!important}
 .admin{flex-direction:column}.side{width:100%;border-right:0;border-bottom:5px solid var(--yellow)}
 .item-row{grid-template-columns:1fr 1fr}
 .nav{position:static;gap:.8rem}
 .nav nav{order:3;flex-basis:100%;gap:.9rem}
 .nav>.btn{margin-left:auto}
}
@media(max-width:520px){
 .g4,.g3,.g2{grid-template-columns:1fr}
 .hero{min-height:420px}
 .slide h1{font-size:1.7rem}
}
</style>