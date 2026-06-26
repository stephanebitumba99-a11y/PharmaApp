import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ProduitService } from '../../services/produitform/produiform';
import { Router, RouterLink } from '@angular/router';

@Component({
  selector: 'app-produitform',
  standalone: true,
  imports: [CommonModule, FormsModule, RouterLink],
  templateUrl: './produitform.html',
  styleUrls: ['./produitform.css']
})
export class ProduitFormComponent {

  produit = {
    name: '',
    category: '',
    quantite: 0,
    price: 0,
    emplacement: '',
    date_expiration: ''
  };

  message = '';
  isLoading = false;
  today = new Date().toISOString().split('T')[0];

  constructor(
    private produitService: ProduitService,
    private router: Router
  ) {}

  submit() {
    // Validation supplémentaire
    if (!this.isFormValid()) {
      this.message = 'Veuillez remplir tous les champs obligatoires';
      return;
    }

    this.isLoading = true;
    this.message = '';

    this.produitService.addProduit(this.produit).subscribe({
      next: (response) => {
        this.isLoading = false;
        // Redirection avec message de succès
        this.router.navigate(['/layout/produit'], { 
          state: { success: true, message: 'Produit ajouté avec succès!' }
        });
      },
      error: (err) => {
        this.isLoading = false;
        console.error('Erreur lors de l\'ajout:', err);
        this.message = err.error?.message || "Erreur lors de l'ajout du produit. Veuillez réessayer.";
      }
    });
  }

  // Validation personnalisée
  private isFormValid(): boolean {
    const { name, category, quantite, price, emplacement, date_expiration } = this.produit;
    return !!(name && category && quantite >= 0 && price >= 0 && emplacement && date_expiration);
  }

  // Réinitialiser le formulaire
  resetForm() {
    this.produit = {
      name: '',
      category: '',
      quantite: 0,
      price: 0,
      emplacement: '',
      date_expiration: ''
    };
    this.message = '';
  }
}