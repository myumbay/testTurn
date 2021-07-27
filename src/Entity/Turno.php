<?php

namespace App\Entity;

use App\Repository\TurnoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TurnoRepository::class)
 */
class Turno
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer",options={"comment" = "2 minutos, 3 minutos"})
     */
    private $tipoTurno;
	
	/**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\Column(type="boolean")
     */
    private $estado;
	
	
	/**
	* @ORM\ManyToOne(targetEntity="Persona", inversedBy="turno")
	* @ORM\JoinColumn(name="persona_id", referencedColumnName="id", nullable=false)
	*/
	private $persona;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipoTurno(): ?int
    {
        return $this->tipoTurno;
    }

    public function setTipoTurno(int $tipoTurno): self
    {
        $this->tipoTurno = $tipoTurno;

        return $this;
    }

    public function getEstado(): ?bool
    {
        return $this->estado;
    }

    public function setEstado(bool $estado): self
    {
        $this->estado = $estado;

        return $this;
    }
	
	public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created= $created;

        return $this;
    }
	
	/**
     * Set persona
     *
     * @param Persona $persona
     * @return Turno
     */
    public function setPersona(Persona $persona = null) {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona
     *
     * @return Persona 
     */
    public function getPersona() {
        return $this->persona;
    }
}
