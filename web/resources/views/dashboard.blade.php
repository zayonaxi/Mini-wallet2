<!DOCTYPE html>
<html>
<head>
<title>Mini Wallet</title>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<div class="container">
<h1>Mini Wallet</h1>

<div class="card">
<h2>Crear Usuario</h2>
<form id="userForm">
<input type="text" id="name" placeholder="Nombre" required>
<input type="email" id="email" placeholder="Email" required>
<button type="submit">Crear</button>
</form>
</div>

<div class="card">
<h2>Registrar Transacción</h2>
<form id="transactionForm">
<input type="number" id="user_id" placeholder="ID Usuario" required>
<select id="type">
<option value="income">Ingreso</option>
<option value="expense">Egreso</option>
</select>
<input type="number" step="0.01" id="amount" placeholder="Monto" required>
<input type="text" id="description" placeholder="Descripción">
<button type="submit">Registrar</button>
</form>
</div>

<div class="card">
<h2>Balance</h2>
<input type="number" id="balance_user_id" placeholder="ID Usuario">
<button onclick="getBalance()">Consultar</button>
<div id="balanceResult"></div>
</div>

<div class="card">
<h2>Transacciones</h2>
<input type="number" id="list_user_id" placeholder="ID Usuario">
<button onclick="getTransactions()">Ver</button>
<table id="table">
<thead><tr><th>Tipo</th><th>Monto</th><th>Descripción</th></tr></thead>
<tbody></tbody>
</table>
</div>

</div>

<script>
document.getElementById('userForm').addEventListener('submit',function(e){
e.preventDefault();
fetch('/api/users',{
method:'POST',
headers:{'Content-Type':'application/json'},
body:JSON.stringify({name:name.value,email:email.value})
}).then(res=>res.json()).then(data=>{
alert("Usuario creado ID: "+data.id);
});
});

document.getElementById('transactionForm').addEventListener('submit',function(e){
e.preventDefault();
fetch('/api/transactions',{
method:'POST',
headers:{'Content-Type':'application/json'},
body:JSON.stringify({
user_id:user_id.value,
type:type.value,
amount:amount.value,
description:description.value
})
}).then(res=>res.json()).then(()=>{
alert("Transacción registrada");
});
});

function getBalance(){
fetch('/api/users/'+balance_user_id.value+'/balance')
.then(res=>res.json())
.then(data=>{
balanceResult.innerHTML="<h3>$"+data.balance+"</h3>";
});
}

function getTransactions(){
fetch('/api/users/'+list_user_id.value+'/transactions')
.then(res=>res.json())
.then(data=>{
let tbody=document.querySelector("#table tbody");
tbody.innerHTML="";
data.forEach(t=>{
tbody.innerHTML+=`<tr><td>${t.type}</td><td>$${t.amount}</td><td>${t.description ?? ''}</td></tr>`;
});
});
}
</script>

</body>
</html>
