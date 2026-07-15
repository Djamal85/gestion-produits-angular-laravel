import { Component, signal } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { Assurance } from './assurance/assurance';
import { Type } from './type/type';
import { Product } from './product/product';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, Assurance, Type, Product],
  templateUrl: './app.html',
  styleUrl: './app.css',
})
export class App {
  protected readonly title = signal('gestion-front-iage');
}
