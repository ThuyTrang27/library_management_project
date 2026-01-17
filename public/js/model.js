class Book {
    constructor(id, title, author, genre, stock, image) {
        this.id = id;
        this.title = title;
        this.author = author;
        this.genre = genre;
        this.stock = stock;
        this.image = image;
    }
}

class Library {
    constructor() {
        this.books = [];
    }

    addBook(book) {
        this.books.push(book);
    }

    getAllBooks() {
        return this.books;
    }

    search(keyword) {
        return this.books.filter(b =>
            b.title.toLowerCase().includes(keyword.toLowerCase())
        );
    }
}