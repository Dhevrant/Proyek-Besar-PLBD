<style>
:root{--ink:#222;--muted:#666;--line:#d6d6d6;--bg:#fff;--soft:#f1f1f1;--accent:#222;--danger:#9b1c1c;--ok:#1f6b3a}
*{box-sizing:border-box}
body{margin:0;font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif;color:var(--ink);background:var(--bg);line-height:1.5}
a{color:inherit}
h1,h2,h3{line-height:1.2;margin:0 0 .6rem}
.container{max-width:1100px;margin:0 auto;padding:1.5rem 1rem 3rem}
.muted{color:var(--muted);font-size:.9rem}
.section{margin:2.5rem 0}
.row-between{display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap}

/* nav */
.nav{display:flex;align-items:center;gap:1.5rem;padding:.8rem 1rem;border-bottom:1px solid var(--ink);flex-wrap:wrap}
.logo{font-weight:700;text-decoration:none;border:1px solid var(--ink);padding:.35rem .8rem;border-radius:6px;background:var(--soft)}
.nav nav{display:flex;gap:1.1rem;flex:1;flex-wrap:wrap}
.nav nav a{text-decoration:none;color:var(--muted)}
.nav nav a.on{color:var(--ink);font-weight:700}

/* buttons & forms */
.btn{display:inline-block;padding:.55rem 1rem;border:1px solid var(--ink);border-radius:8px;background:#fff;color:var(--ink);text-decoration:none;cursor:pointer;font:inherit}
.btn-dark{background:var(--accent);color:#fff}
.btn-sm{padding:.3rem .7rem;font-size:.9rem}
.btn-block{display:block;width:100%;text-align:center}
.btn[disabled],.btn.off{opacity:.6;pointer-events:none}
input,select,textarea{width:100%;padding:.6rem .7rem;border:1px solid var(--ink);border-radius:8px;font:inherit;background:#fff}
textarea{min-height:90px;resize:vertical}
label{display:block;font-weight:600;margin:.8rem 0 .25rem}
.radio{display:flex;gap:.5rem;align-items:center;font-weight:400;margin:.3rem 0}
.radio input{width:auto}
.hp{position:absolute;left:-9999px}

/* cards */
.card{border:1px solid var(--ink);border-radius:8px;padding:1rem;background:#fff}
.grid{display:grid;gap:1rem}
.g4{grid-template-columns:repeat(4,1fr)}
.g3{grid-template-columns:repeat(3,1fr)}
.g2{grid-template-columns:1fr 1fr}
.ph{background:#e8e8e8;border:1px solid var(--line);border-radius:6px;display:flex;align-items:center;justify-content:center;color:var(--muted);aspect-ratio:4/3}
.thumb{width:100%;aspect-ratio:4/3;object-fit:cover;border-radius:6px;border:1px solid var(--line)}
.menu-card h3{font-size:1rem;margin:.6rem 0 .2rem}
.price{margin:.2rem 0 .5rem}
.st-ok{color:var(--ok);font-size:.85rem}.st-no{color:var(--danger);font-size:.85rem}

/* hero */
.hero{position:relative;background:var(--soft);border:1px solid var(--ink);border-radius:8px;min-height:280px;overflow:hidden}
.slide{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:1rem;opacity:0;transition:opacity .6s}
.slide.on{opacity:1}
.slide h1{font-size:2rem}
.dots{position:absolute;bottom:.8rem;width:100%;text-align:center}
.dot{display:inline-block;width:9px;height:9px;border-radius:50%;border:1px solid var(--ink);margin:0 3px;background:#fff}
.dot.on{background:var(--ink)}

/* map, tables, pills, alerts */
.map{border:1px solid var(--ink);border-radius:8px;min-height:240px;background:#e8e8e8;overflow:hidden}
.map iframe{width:100%;height:100%;min-height:240px;border:0}
table{width:100%;border-collapse:collapse}
th,td{text-align:left;padding:.55rem .5rem;border-bottom:1px dashed #aaa;vertical-align:top}
.table-wrap{overflow-x:auto}
.pill{display:inline-block;border:1px solid var(--ink);border-radius:999px;padding:.1rem .7rem;font-size:.85rem;text-decoration:none}
.pill.on{background:var(--ink);color:#fff}
.filters{display:flex;gap:.6rem;flex-wrap:wrap;align-items:center;margin-bottom:1rem}
.filters form{flex:1;min-width:200px}
.alert{padding:.7rem 1rem;border-radius:8px;margin:1rem 0;border:1px solid}
.alert-error{background:#fdecec;border-color:var(--danger);color:var(--danger)}
.alert-success{background:#e9f7ee;border-color:var(--ok);color:var(--ok)}
.pager{display:flex;gap:.4rem;justify-content:center;margin-top:1.5rem}
.pager a,.pager span{width:34px;height:34px;border:1px solid var(--ink);border-radius:50%;display:flex;align-items:center;justify-content:center;text-decoration:none}
.pager .on{background:var(--ink);color:#fff}.pager .dis{opacity:.35}

/* FAQ */
details.faq{border:1px solid var(--ink);border-radius:8px;padding:.8rem 1rem;margin-bottom:.7rem}
details.faq summary{font-weight:700;cursor:pointer}
details.faq p{margin:.6rem 0 0}

/* order form */
.item-row{display:grid;grid-template-columns:1fr auto auto auto auto;gap:.8rem;align-items:center;padding:.6rem 0;border-bottom:1px dashed #aaa}
.qty{display:flex;align-items:center;gap:.4rem}
.qty button{width:34px;height:34px;border:1px solid var(--ink);background:#fff;border-radius:8px;cursor:pointer;font-size:1.1rem}
.qty input{width:56px;text-align:center}
.total{display:flex;justify-content:space-between;font-weight:700;font-size:1.1rem;margin:.6rem 0}

/* footer */
.footer{background:var(--soft);border-top:1px solid var(--line);padding:1.5rem 1rem}
.footer .in{max-width:1100px;margin:0 auto;display:flex;justify-content:space-between;gap:2rem;flex-wrap:wrap}
.footer a{display:block;text-decoration:none;color:var(--muted)}
.wa-float{position:fixed;right:16px;bottom:16px;z-index:10;box-shadow:0 2px 8px rgba(0,0,0,.25)}

/* admin */
.admin{display:flex;min-height:100vh}
.side{width:210px;background:var(--soft);border-right:2px solid var(--ink);padding:1rem .8rem;flex-shrink:0}
.side .logo{display:block;text-align:center;margin-bottom:1rem}
.side a,.side button.lnk{display:block;padding:.45rem .6rem;text-decoration:none;border:1px solid transparent;border-radius:8px;background:none;font:inherit;text-align:left;width:100%;cursor:pointer;color:inherit}
.side a.on{border-color:var(--ink);background:#fff;font-weight:700}
.side hr{border:0;border-top:1px solid var(--line);margin:1rem 0}
.main{flex:1;padding:1.5rem;min-width:0}
.stat b{display:block;font-size:1.8rem}
.login-box{max-width:420px;margin:3rem auto}
.mini-form{display:inline}
@media(max-width:800px){
 .g4,.g3,.g2{grid-template-columns:1fr 1fr}
 .admin{flex-direction:column}.side{width:100%;border-right:0;border-bottom:2px solid var(--ink)}
 .item-row{grid-template-columns:1fr 1fr}
}
@media(max-width:520px){.g4,.g3,.g2{grid-template-columns:1fr}}
</style>
