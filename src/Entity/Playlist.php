<?php

namespace App\Entity;

use App\Repository\PlaylistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlaylistRepository::class)
 */
class Playlist
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_formation;
    
    
    
    /**
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    /*private $nbFormation;*/

    /**
     * @ORM\OneToMany(targetEntity=Formation::class, mappedBy="playlist")
     */
    private $formations;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
        $this->nb_formation = 0;
    }
     

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
    
    public function getnb_formation(): ?int
    {
        return $this->nb_formation;
    }

    public function setnb_formation(?int $nb_formation): self
    {
        $this->nb_formation = $nb_formation;

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getFormations(): Collection
    {   
        return $this->formations;
    }   
    
   

    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->setPlaylist($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getPlaylist() === $this) {
                $formation->setPlaylist(null);
            }
        }

        return $this;
    }
   /**
    * @return Collection<int, string>
    */	
    public function getCategoriesPlaylist() : Collection 
    {
	$categories = new ArrayCollection();
	foreach($this->formations as $formation){
            $categoriesFormation = $formation->getCategories();
            foreach($categoriesFormation as $categorieFormation){
                if(!$categories->contains($categorieFormation->getName())){
                    $categories[] = $categorieFormation->getName();
		}
            }
        }
        // Si aucune formation, retourner une collection vide
        if ($categories->isEmpty()) {
            return new ArrayCollection();
        }
	return $categories;
	
    }
}
