'use strict'

console.log(bd_tables);

const select_table=document.getElementById('select_table');
const select_field_1=document.getElementById('select_field_1');
const select_field_2=document.getElementById('select_field_2');
//cuando el cliente cambie de tabla, muestra los campos de dicha tabla
select_table.addEventListener("change",(e)=>{
    const newTable=bd_tables.find(tbl=>tbl.name===e.target.value);
    const options1=newTable.fields
        .map((fld,i)=>`'<option value="${fld}" ${i===0?'selected':''} >${fld}</option>`)
        .join(' ');

    const options2=newTable.fields
        .map((fld,i)=>`'<option value="${fld}" ${i===1?'selected':''} >${fld}</option>`)
        .join(' ');
    select_field_1.innerHTML=options1;
    select_field_2.innerHTML=options2;
})