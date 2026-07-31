<?php
class VehicleModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(array $data, array $photos): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO vehicles (user_id, marca, modelo, ano, cor, quilometragem, descricao, valor, estado, cidade) VALUES (:user_id, :marca, :modelo, :ano, :cor, :quilometragem, :descricao, :valor, :estado, :cidade)');
        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':marca' => $data['marca'],
            ':modelo' => $data['modelo'],
            ':ano' => $data['ano'],
            ':cor' => $data['cor'],
            ':quilometragem' => $data['quilometragem'],
            ':descricao' => $data['descricao'],
            ':valor' => $data['valor'],
            ':estado' => $data['estado'],
            ':cidade' => $data['cidade'],
        ]);

        $vehicleId = (int) $this->pdo->lastInsertId();
        $photoStmt = $this->pdo->prepare('INSERT INTO vehicle_photos (vehicle_id, path) VALUES (:vehicle_id, :path)');
        foreach ($photos as $path) {
            $photoStmt->execute([':vehicle_id' => $vehicleId, ':path' => $path]);
        }

        return $vehicleId;
    }

    public function list(array $filters = []): array
    {
        $sql = 'SELECT v.*, GROUP_CONCAT(vp.path ORDER BY vp.id) as photos FROM vehicles v LEFT JOIN vehicle_photos vp ON vp.vehicle_id = v.id';
        $where = [];
        $params = [];

        if (!empty($filters['marca'])) {
            $where[] = 'v.marca = :marca';
            $params[':marca'] = $filters['marca'];
        }
        if (!empty($filters['modelo'])) {
            $where[] = 'v.modelo = :modelo';
            $params[':modelo'] = $filters['modelo'];
        }
        if (!empty($filters['estado'])) {
            $where[] = 'v.estado = :estado';
            $params[':estado'] = $filters['estado'];
        }
        if (!empty($filters['cidade'])) {
            $where[] = 'v.cidade = :cidade';
            $params[':cidade'] = $filters['cidade'];
        }
        if (!empty($filters['valor_max'])) {
            $where[] = 'v.valor <= :valor_max';
            $params[':valor_max'] = $filters['valor_max'];
        }

        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        $sql .= ' GROUP BY v.id ORDER BY v.id DESC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT v.*, GROUP_CONCAT(vp.path) as photos FROM vehicles v LEFT JOIN vehicle_photos vp ON vp.vehicle_id = v.id WHERE v.id = :id GROUP BY v.id');
        $stmt->execute([':id' => $id]);
        $vehicle = $stmt->fetch();
        return $vehicle ?: null;
    }
}
