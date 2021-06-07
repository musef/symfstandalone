<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PedidosClientes
 *
 * @ORM\Table(name="pedidos_clientes")
 * @ORM\Entity
 */
class PedidosClientes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha", type="string", length=20, nullable=false)
     */
    private $fecha;

    /**
     * @var string|null
     *
     * @ORM\Column(name="id_cliente", type="string", length=250, nullable=true)
     */
    private $idCliente = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="importe", type="decimal", precision=10, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $importe = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="iva", type="decimal", precision=10, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $iva = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="importe_total", type="decimal", precision=10, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $importeTotal = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="envio", type="decimal", precision=5, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $envio = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="carrito", type="text", nullable=true)
     */
    private $carrito;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getFecha(): ?string
    {
        return $this->fecha;
    }

    public function setFecha(string $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getIdCliente(): ?string
    {
        return $this->idCliente;
    }

    public function setIdCliente(?string $idCliente): self
    {
        $this->idCliente = $idCliente;

        return $this;
    }

    public function getImporte(): ?string
    {
        return $this->importe;
    }

    public function setImporte(string $importe): self
    {
        $this->importe = $importe;

        return $this;
    }

    public function getIva(): ?string
    {
        return $this->iva;
    }

    public function setIva(string $iva): self
    {
        $this->iva = $iva;

        return $this;
    }

    public function getImporteTotal(): ?string
    {
        return $this->importeTotal;
    }

    public function setImporteTotal(string $importeTotal): self
    {
        $this->importeTotal = $importeTotal;

        return $this;
    }

    public function getEnvio(): ?string
    {
        return $this->envio;
    }

    public function setEnvio(string $envio): self
    {
        $this->envio = $envio;

        return $this;
    }

    public function getCarrito(): ?string
    {
        return $this->carrito;
    }

    public function setCarrito(?string $carrito): self
    {
        $this->carrito = $carrito;

        return $this;
    }


}
