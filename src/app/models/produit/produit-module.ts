export interface Produit {
  id: number;
  name: string;
  category: string;
  price: number;
  quantite: number;
  emplacement: string;
  date_expiration?: string;
}