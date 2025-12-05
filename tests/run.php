<?php
require_once __DIR__ . '/../config/autoload.php';

function ok($msg){ echo "[OK] $msg\n"; }
function fail($msg){ echo "[FAIL] $msg\n"; }

// Test 1: DB connection
try{
    $db = (new Database())->conectar();
    if ($db instanceof PDO) ok('Conexão com o banco estabelecida');
    else fail('Conexão retornou objeto inesperado');
}catch(Exception $e){
    fail('Conexão falhou: ' . $e->getMessage());
}

// Test 2: PlaceModel::all
try{
    $pm = new PlaceModel();
    $all = $pm->all();
    if (is_array($all)) ok('PlaceModel::all() retornou array (' . count($all) . ')');
    else fail('PlaceModel::all() não retornou array');
}catch(Exception $e){
    fail('Erro em PlaceModel::all(): ' . $e->getMessage());
}

// Test 3: PlaceModel::find with invalid id
try{
    $res = $pm->find(999999);
    if ($res === false) ok('PlaceModel::find(invalid) retornou false');
    else ok('PlaceModel::find(invalid) retornou: ' . (is_array($res) ? 'array' : gettype($res)));
}catch(Exception $e){
    fail('Erro em PlaceModel::find(): ' . $e->getMessage());
}

// Test 4: UserModel::findById with invalid id
try{
    $um = new UserModel();
    $u = $um->findById(999999);
    if ($u === false) ok('UserModel::findById(invalid) retornou false');
    else ok('UserModel::findById(invalid) retornou: ' . (is_array($u) ? 'array' : gettype($u)));
}catch(Exception $e){
    fail('Erro em UserModel::findById(): ' . $e->getMessage());
}

// Test 5: PurchaseModel exists
try{
    $purch = new PurchaseModel();
    ok('PurchaseModel instanciado com sucesso');
}catch(Exception $e){
    fail('Erro ao instanciar PurchaseModel: ' . $e->getMessage());
}

// Test 6: PurchaseModel::purchaseHistory
try{
    $history = $purch->purchaseHistory(1);
    if (is_array($history)) ok('PurchaseModel::purchaseHistory(1) retornou array (' . count($history) . ')');
    else fail('PurchaseModel::purchaseHistory não retornou array');
}catch(Exception $e){
    fail('Erro em PurchaseModel::purchaseHistory(): ' . $e->getMessage());
}

// Test 7: PlaceModel with full address info
try{
    $place = $pm->find(1);
    if ($place && isset($place['logradouro'])) ok('PlaceModel::find retorna campos de endereço (logradouro, etc)');
    else if ($place) ok('PlaceModel::find retornou dados mas sem endereço completo');
    else fail('PlaceModel::find não retornou dados válidos');
}catch(Exception $e){
    fail('Erro em PlaceModel::find: ' . $e->getMessage());
}

echo "\nTeste concluído.\n";
