export type CategoriesResponse = {
  data: {
    categories: Category[]
  }
  message: null
  success: boolean
}

export type Category = {
  id: number
  name: string
}
