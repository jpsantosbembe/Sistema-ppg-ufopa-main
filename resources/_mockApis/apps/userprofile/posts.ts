// project imports
import { Chance } from 'chance';

// types
import type { Post } from '@/Types/apps/PostType';

// assets
import image1 from '$/assets/images/products/s1.jpg';
import image2 from '$/assets/images/products/s2.jpg';
import image4 from '$/assets/images/products/s4.jpg';
import user1 from '$/assets/images/profile/user1.jpg';
import user2 from '$/assets/images/profile/user2.jpg';
import user3 from '$/assets/images/profile/user3.jpg';
import user4 from '$/assets/images/profile/user4.jpg';
import user5 from '$/assets/images/profile/user5.jpg';

const chance = new Chance();

// social profile
let posts: Post[] = [
    {
        id: '#1POST_MATHEW',
        profile: {
            id: '#52MATHEW',
            avatar: user1,
            name: 'Mathew Anderson',
            time: '15 min ago'
        },
        data: {
            content: chance.paragraph({ sentences: 2 }),
            images: [
                {
                    img: image1,
                    featured: true
                }
            ],
            likes: {
                like: true,
                value: 102
            },
            comments: [
                {
                    id: '#3COMMENTMATHEWE',
                    profile: {
                        id: '#52MATHEW',
                        avatar: user3,
                        name: 'Deran Mac',
                        time: '8 mins ago '
                    },
                    data: {
                        comment: chance.paragraph({ sentences: 1 }),
                        likes: {
                            like: true,
                            value: 55
                        }
                    }
                },
                {
                    id: '#2COMMENT_MATHEW',
                    profile: {
                        id: '#52MATHEW',
                        avatar: user4,
                        name: 'Jonathan Bg',
                        time: '5 mins ago '
                    },
                    data: {
                        comment:
                        chance.paragraph({ sentences: 1 }),
                        likes: {
                            like: false,
                            value: 68
                        },
                        replies: [
                            {
                                id: '#1REPLY_MATHEW',
                                profile: {
                                    id: '#52MATHEW',
                                    avatar: user5,
                                    name: 'Carry minati',
                                    time: 'just now '
                                },
                                data: {
                                    comment: chance.paragraph({ sentences: 1 }),
                                    likes: {
                                        like: true,
                                        value: 10
                                    }
                                }
                            }
                        ]
                    }
                }
            ]
        }
    },
    {
        id: '#4POST_CARRY',
        profile: {
            id: '#52CARRY',
            avatar: user1,
            name: 'Carry Minati',
            time: 'now'
        },
        data: {
            content: chance.paragraph({ sentences: 2 }),
            images: [],
            likes: {
                like: false,
                value: 67
            },
            comments: []
        }
    },
    {
        id: '#2POST_GENELIA',
        profile: {
            id: '#52GENELIA',
            avatar: user2,
            name: 'Genelia Desouza',
            time: '15 min ago '
        },
        data: {
            content: chance.paragraph({ sentences: 1 }),
            images: [
                {
                    img: image2,
                    title: 'Image Title'
                },
                {
                    img: image4,
                    title: 'Painter'
                }
            ],
            likes: {
                like: false,
                value: 320
            },
            comments: [
                {
                    id: '#2COMMENT_GENELIA',
                    profile: {
                        id: '#52GENELIA',
                        avatar: user3,
                        name: 'Ritesh Deshmukh',
                        time: '15 min ago '
                    },
                    data: {
                        comment:
                        chance.paragraph({ sentences: 1 }),
                        likes: {
                            like: true,
                            value: 65
                        },
                        replies: []
                    }
                }
            ]
        }
    },
    {
        id: '#3POST_Mathew',
        profile: {
            id: '#52Mathew',
            avatar: user1,
            name: 'Mathew Anderson',
            time: '15 min ago '
        },
        data: {
            content: chance.paragraph({ sentences: 1 }),
            images: [],
            video: 'd1-FRj20WBE',
            likes: {
                like: true,
                value: 130
            }
        }
    }
];

// ==============================|| MOCK SERVICES ||============================== //

//mock.onGet('/api/posts/list').reply(200, { posts });

export {posts}
