import { Component, OnInit, signal, computed } from '@angular/core';
import { CommonModule, DatePipe } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ProduitService } from '../../services/produit/produit';
import { RouterLink } from "@angular/router";

@Component({
  selector: 'app-produits',
  standalone: true,
  imports: [CommonModule, FormsModule, RouterLink, DatePipe],
  templateUrl: './produit.html',
  styleUrls: ['./produit.css']
})
export class ProduitsComponent implements OnInit {

  // =====================
  // SIGNALS
  // =====================
  produits = signal<any[]>([]);
  search = signal('');

  currentPage = signal(1);
  pageSize = signal(5); // 

  constructor(private produitService: ProduitService) {}

  ngOnInit(): void {
    this.loadProduits();
  }

  // =====================
  // LOAD DATA
  // =====================
  loadProduits() {
    this.produitService.getProduits().subscribe({
      next: (res: any) => {
        this.produits.set(res.data || []);
      },
      error: (err: any) => {
        console.error('Erreur chargement produits:', err);
      }
    });
  }

  // =====================
  // EXPIRATION CHECK
  // =====================
  isExpiringSoon(dateExpiration: string): boolean {
    if (!dateExpiration) return false;

    const today = new Date();
    const expDate = new Date(dateExpiration);

    const diffTime = expDate.getTime() - today.getTime();
    const diffDays = diffTime / (1000 * 60 * 60 * 24);

    return diffDays <= 30 && diffDays >= 0;
  }

  // =====================
  // FILTER
  // =====================
  filteredProduits = computed(() => {
    const value = this.search().toLowerCase().trim();

    if (!value) return this.produits();

    return this.produits().filter(p =>
      p.name?.toLowerCase().includes(value)
    );
  });

  // =====================
  // PAGINATION
  // =====================
  paginatedProduits = computed(() => {

    const data = this.filteredProduits();

    const start = (this.currentPage() - 1) * this.pageSize();
    const end = start + this.pageSize();

    return data.slice(start, end);
  });

  totalPages = computed(() => {
    const size = this.pageSize();
    if (size <= 0) return 1;

    return Math.ceil(this.filteredProduits().length / size);
  });

  nextPage() {
    if (this.currentPage() < this.totalPages()) {
      this.currentPage.update(p => p + 1);
    }
  }

  prevPage() {
    if (this.currentPage() > 1) {
      this.currentPage.update(p => p - 1);
    }
  }


  updateSearch(event: any) {
    this.search.set(event.target.value);
    this.currentPage.set(1); // reset page
  }

  clearSearch() {
    this.search.set('');
    this.currentPage.set(1);
  }

 
  getStockCount(): number {
    return this.produits().filter(p => p.quantite > 0).length;
  }

  getLowStockCount(): number {
    return this.produits().filter(p => p.quantite > 0 && p.quantite < 10).length;
  }

  getOutOfStockCount(): number {
    return this.produits().filter(p => p.quantite === 0).length;
  }

 
  formatNumber(value: number): string {
    if (!value && value !== 0) return '0';
    return new Intl.NumberFormat('fr-FR').format(value);
  }
}