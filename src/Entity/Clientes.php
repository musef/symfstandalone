<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clientes
 *
 * @ORM\Table(name="clientes")
 * @ORM\Entity
 */
class Clientes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="clientes_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha", type="string", length=20, nullable=false, options={"default"="0000-00-00 00:00:00"})
     */
    private $fecha = '0000-00-00 00:00:00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="doc_identidad_tipo", type="string", length=10, nullable=true)
     */
    private $docIdentidadTipo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="doc_identidad", type="string", length=15, nullable=true)
     */
    private $docIdentidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="apellido1", type="string", length=50, nullable=true)
     */
    private $apellido1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="apellido2", type="string", length=50, nullable=true)
     */
    private $apellido2;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     */
    private $fechaNacimiento;

    /**
     * @var string|null
     *
     * @ORM\Column(name="direccion", type="string", length=150, nullable=true)
     */
    private $direccion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="direccion_complemento", type="string", length=100, nullable=true)
     */
    private $direccionComplemento;

    /**
     * @var string|null
     *
     * @ORM\Column(name="localidad", type="string", length=50, nullable=true)
     */
    private $localidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="provincia", type="string", length=50, nullable=true)
     */
    private $provincia;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cod_postal", type="string", length=5, nullable=true)
     */
    private $codPostal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tlf_fijo", type="string", length=10, nullable=true)
     */
    private $tlfFijo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tlf_movil", type="string", length=10, nullable=true)
     */
    private $tlfMovil;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="cuenta_iban", type="string", length=24, nullable=false, options={"default"="0000"})
     */
    private $cuentaIban = '0000';

    /**
     * @var string|null
     *
     * @ORM\Column(name="envio_direccion", type="string", length=150, nullable=true)
     */
    private $envioDireccion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="envio_localidad", type="string", length=50, nullable=true)
     */
    private $envioLocalidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="envio_provincia", type="string", length=50, nullable=true)
     */
    private $envioProvincia;

    /**
     * @var string|null
     *
     * @ORM\Column(name="envio_cp", type="string", length=5, nullable=true)
     */
    private $envioCp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="check_confidencialidad", type="string", length=10, nullable=true)
     */
    private $checkConfidencialidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="check_datos", type="string", length=10, nullable=true)
     */
    private $checkDatos;

    public function getId(): ?int
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

    public function getDocIdentidadTipo(): ?string
    {
        return $this->docIdentidadTipo;
    }

    public function setDocIdentidadTipo(?string $docIdentidadTipo): self
    {
        $this->docIdentidadTipo = $docIdentidadTipo;

        return $this;
    }

    public function getDocIdentidad(): ?string
    {
        return $this->docIdentidad;
    }

    public function setDocIdentidad(?string $docIdentidad): self
    {
        $this->docIdentidad = $docIdentidad;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido1(): ?string
    {
        return $this->apellido1;
    }

    public function setApellido1(?string $apellido1): self
    {
        $this->apellido1 = $apellido1;

        return $this;
    }

    public function getApellido2(): ?string
    {
        return $this->apellido2;
    }

    public function setApellido2(?string $apellido2): self
    {
        $this->apellido2 = $apellido2;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(?\DateTimeInterface $fechaNacimiento): self
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getDireccionComplemento(): ?string
    {
        return $this->direccionComplemento;
    }

    public function setDireccionComplemento(?string $direccionComplemento): self
    {
        $this->direccionComplemento = $direccionComplemento;

        return $this;
    }

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function setLocalidad(?string $localidad): self
    {
        $this->localidad = $localidad;

        return $this;
    }

    public function getProvincia(): ?string
    {
        return $this->provincia;
    }

    public function setProvincia(?string $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    public function getCodPostal(): ?string
    {
        return $this->codPostal;
    }

    public function setCodPostal(?string $codPostal): self
    {
        $this->codPostal = $codPostal;

        return $this;
    }

    public function getTlfFijo(): ?string
    {
        return $this->tlfFijo;
    }

    public function setTlfFijo(?string $tlfFijo): self
    {
        $this->tlfFijo = $tlfFijo;

        return $this;
    }

    public function getTlfMovil(): ?string
    {
        return $this->tlfMovil;
    }

    public function setTlfMovil(?string $tlfMovil): self
    {
        $this->tlfMovil = $tlfMovil;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCuentaIban(): ?string
    {
        return $this->cuentaIban;
    }

    public function setCuentaIban(string $cuentaIban): self
    {
        $this->cuentaIban = $cuentaIban;

        return $this;
    }

    public function getEnvioDireccion(): ?string
    {
        return $this->envioDireccion;
    }

    public function setEnvioDireccion(?string $envioDireccion): self
    {
        $this->envioDireccion = $envioDireccion;

        return $this;
    }

    public function getEnvioLocalidad(): ?string
    {
        return $this->envioLocalidad;
    }

    public function setEnvioLocalidad(?string $envioLocalidad): self
    {
        $this->envioLocalidad = $envioLocalidad;

        return $this;
    }

    public function getEnvioProvincia(): ?string
    {
        return $this->envioProvincia;
    }

    public function setEnvioProvincia(?string $envioProvincia): self
    {
        $this->envioProvincia = $envioProvincia;

        return $this;
    }

    public function getEnvioCp(): ?string
    {
        return $this->envioCp;
    }

    public function setEnvioCp(?string $envioCp): self
    {
        $this->envioCp = $envioCp;

        return $this;
    }

    public function getCheckConfidencialidad(): ?string
    {
        return $this->checkConfidencialidad;
    }

    public function setCheckConfidencialidad(?string $checkConfidencialidad): self
    {
        $this->checkConfidencialidad = $checkConfidencialidad;

        return $this;
    }

    public function getCheckDatos(): ?string
    {
        return $this->checkDatos;
    }

    public function setCheckDatos(?string $checkDatos): self
    {
        $this->checkDatos = $checkDatos;

        return $this;
    }


}
