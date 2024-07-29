export type PostsResponse = {
  data: Data
  message: null
  success: boolean
}

export type Data = {
  posts: Post[]
  from: number
  to: number
  total: number
  per_page: number
  current_page: number
  last_page: number
  next_page_url: null
  previous_page_url: null
}

export type Post = {
  id: number
  image: string
  content: string
  since: string
  likes: number
  dislikes: number
  my_reaction: "like" | "dislike"
  comments: Comment[]
}

export type Comment = {
  id: number | string
  comment: string
  since: string
  user: null | {
    id: number
    name: string
    image: string
  }
}
